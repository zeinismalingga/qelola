        </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Qelola 2021</div>
                        </div>
                    </div>
                </footer>
            </div>

 </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>

            // global vars
            let input = {};
            let pmt = {};

            function countFv(rate, nper, pmt, pv, type) {
                // menghitung future value
                var pow = Math.pow(1 + rate, nper),
                    fv;
                if (rate) {
                    fv = (pmt * (1 + rate * type) * (1 - pow) / rate) - pv * pow;
                } else {
                    fv = -1 * (pv + pmt * nper);
                }
                return fv.toFixed(2);
            }

            function roundOff(value, dplaces) {
                // pembulatan
                value = value.toString()

                if ((value.indexOf(".") != -1) && (value.length > (value.indexOf(".") + dplaces))) {
                    three = value.substring(value.indexOf(".") + dplaces + 1, value.indexOf(".") + dplaces + 2)
                    one = value.substring(0, value.indexOf(".") + dplaces)
                    two = value.substring(value.indexOf(".") + dplaces, value.indexOf(".") + dplaces + 1)
                    if (parseInt(three) >= 5) { value = one + (parseInt(two) + 1); value = parseFloat(value) }
                    else { value = one + two; value = parseFloat(value) }
                }
                return value;
            }

            function countPmt(r, np, pv, fv, type) {
                // menghitung pmt
                if (!fv) fv = 0;
                pmt = -(r * (fv + Math.pow((1 + r), np) * pv) / (-1 + Math.pow((1 + r), np)));
                finalPmt = roundOff(pmt, 2);
                return finalPmt;
            }

            function calculate() {
                // setup data
                const form = document.getElementById('financial_calculator');
                input = {
                    pv1: form.pv1.value,
                    r: form.r.value,
                    n: form.n.value,
                    pv: form.pv.value,
                    i: form.i.value,
                }
                const m_r = input.r / 12 / 100; // monthly inflation rate
                const m_n = 12 * input.n; // n of period in month

                // monthly future value
                const m_fv = parseFloat(countFv(m_r, m_n, 0, input.pv1, 0));
                // monthly PMT
                const m_i = input.i / 12 / 100; // monthly investment rate 
                const m_pmt = countPmt(m_i, m_n, input.pv, m_fv);

                // yearly future value
                const y_r = input.r / 100;
                const y_fv = parseFloat(countFv(y_r, input.n, 0, input.pv1, 0));

                // yearly PMT
                const y_i = input.i / 100;
                const y_pmt = countPmt(y_i, input.n, input.pv, y_fv);

                return {
                    m_pmt: m_pmt,
                    y_pmt: y_pmt
                }
            }

            // MAIN
            var calculate = document.getElementById('calculate');
            if(calculate){
                document.getElementById('calculate').onclick = () => {
                    pmt = calculate();
                    if ((pmt.m_pmt === "NaN") || (pmt.m_pmt === "Infinity")) {
                        document.getElementById('result').classList.add('hidden');
                        alert('Harap memasukkan nilai yang benar');
                    } else {
                        document.getElementById('m_pmt').value = pmt.m_pmt.toLocaleString('id');
                        document.getElementById('y_pmt').value = pmt.y_pmt.toLocaleString('id');
                        document.getElementById('result').classList.remove('hidden');
                    }
                }
            }
            
        </script>
        <script>
            $( document ).ready(function() {

              $('#calculate2').click(function() {

                no_1 = parseInt($("input[name=no_1]:checked").val());
                no_2 = parseInt($("input[name=no_2]:checked").val());
                no_3 = parseInt($("input[name=no_3]:checked").val());
                no_4 = parseInt($("input[name=no_4]:checked").val());
                no_5 = parseInt($("input[name=no_5]:checked").val());
                no_6 = parseInt($("input[name=no_6]:checked").val());
                no_7 = parseInt($("input[name=no_7]").val());

                
                if(no_1 !== undefined || no_2 !== undefined || no_3 !== undefined || no_4 !== undefined || no_5 !== undefined || no_6 !== undefined){

                    result = no_1 + no_2 + no_3 + no_4 + no_5 + no_6;

                    risk_tolerance_score = no_3 + no_4 + no_5 + no_6;
                    time_horizone = no_1 + no_2;
                    
                    $.post("<?php echo site_url('profil_risiko/add') ?>",
                      {
                        no_1: no_1,
                        no_2: no_2,
                        no_3: no_3,
                        no_4: no_4,
                        no_5: no_5,
                        no_6: no_6,
                        no_7: no_7,
                        risk_tolerance_score: risk_tolerance_score,
                        time_horizone: time_horizone
                      },
                      function(data){
                        if(time_horizone < 4){
                            alert('very short investment time horizon. For such a short time horizon, a relatively low-risk portfolio of 40% short-term (average maturity of five years or less) bonds or bond funds and 60% cash investments is suggested, as stock investments may be significantly more volatile in the short term.')
                        // Konservatif
                        }else if(risk_tolerance_score > 0 && risk_tolerance_score < 20 && time_horizone > 3 && time_horizone < 6){
                            $(".judul_ket").html("Konservatif");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 45%");
                            $("#emas").html("Emas 30%");
                            $("#reksadana_saham").html("Reksadana Saham 10%");
                            $("#saham").html("");
                        }else if(risk_tolerance_score > 0 && risk_tolerance_score < 11 && time_horizone > 6 && time_horizone < 11){
                            $(".judul_ket").html("Konservatif");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 45%");
                            $("#emas").html("Emas 30%");
                            $("#reksadana_saham").html("Reksadana Saham 10%");
                            $("#saham").html("");
                        }else if(risk_tolerance_score > 0 && risk_tolerance_score < 6 && time_horizone > 11 && time_horizone < 19){
                            $(".judul_ket").html("Konservatif");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 45%");
                            $("#emas").html("Emas 30%");
                            $("#reksadana_saham").html("Reksadana Saham 10%");
                            $("#saham").html("");
                        }
                        // Moderat
                        else if(risk_tolerance_score > 5 && risk_tolerance_score < 23 && time_horizone > 11 && time_horizone < 19){
                            $(".judul_ket").html("Moderat");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 20%");
                            $("#emas").html("Emas 20%");
                            $("#reksadana_saham").html("Reksadana Saham 35%");
                            $("#saham").html("Saham 10%");
                        }else if(risk_tolerance_score > 11 && risk_tolerance_score < 24 && time_horizone > 6 && time_horizone < 11){
                            $(".judul_ket").html("Moderat");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 20%");
                            $("#emas").html("Emas 20%");
                            $("#reksadana_saham").html("Reksadana Saham 35%");
                            $("#saham").html("Saham 10%");
                        }else if(risk_tolerance_score > 20 && risk_tolerance_score < 31 && time_horizone > 3 && time_horizone < 6){
                            $(".judul_ket").html("Moderat");
                            $("#tabungan").html("Tabungan 15%");
                            $("#reksadana").html("Reksadana Pasar Uang 20%");
                            $("#emas").html("Emas 20%");
                            $("#reksadana_saham").html("Reksadana Saham 35%");
                            $("#saham").html("Saham 10%");
                        }
                        // Agresif
                        else if(risk_tolerance_score > 21 && risk_tolerance_score < 35 && time_horizone > 11 && time_horizone < 19){
                            $(".judul_ket").html("Agresif");
                            $("#tabungan").html("Tabungan 10%");
                            $("#reksadana").html("Reksadana Pasar Uang / Obligasi/Sukuk 15%");
                            $("#emas").html("Reksadana Pendapatan Tetap / Emas 15%");
                            $("#reksadana_saham").html("Reksadana Saham 30%");
                            $("#saham").html("Saham 30%");
                        }else if(risk_tolerance_score > 24 && risk_tolerance_score < 35 && time_horizone > 6 && time_horizone < 11){
                            $(".judul_ket").html("Agresif");
                            $("#tabungan").html("Tabungan 10%");
                            $("#reksadana").html("Reksadana Pasar Uang / Obligasi/Sukuk 15%");
                            $("#emas").html("Reksadana Pendapatan Tetap / Emas 15%");
                            $("#reksadana_saham").html("Reksadana Saham 30%");
                            $("#saham").html("Saham 30%");
                        }else if(risk_tolerance_score > 31 && risk_tolerance_score < 35 && time_horizone > 3 && time_horizone < 6){
                            $(".judul_ket").html("Agresif");
                            $("#tabungan").html("Tabungan 10%");
                            $("#reksadana").html("Reksadana Pasar Uang / Obligasi/Sukuk 15%");
                            $("#emas").html("Reksadana Pendapatan Tetap / Emas 15%");
                            $("#reksadana_saham").html("Reksadana Saham 30%");
                            $("#saham").html("Saham 30%");
                        }

                      });
                }   
                

              });

                $('#reload').click(function() {
                    location.reload();
                });


            });
        </script>       
    </body>
</html>