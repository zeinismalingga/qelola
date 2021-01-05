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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
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
        </script>
    </body>
</html>