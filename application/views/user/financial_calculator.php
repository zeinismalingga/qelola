<h1 class="mt-4"><?php echo $title; ?></h1>
<div class="row">
	<div class="col-md-6">
		<div class="card mb-4">
	        <div class="card-header">
		        <i class="fas fa-calculator"></i>
		        Financial Calculator
		    </div>
		    <div class="card-body">
		    	<form id="financial_calculator" onsubmit="event.preventDefault();">
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Biaya saat ini (Rp)</label>
				    <div class="col-sm-5">
				      <input type="text" name="pv1" class="form-control" placeholder="Rp">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Kenaikan biaya per tahun (%)</label>
				    <div class="col-sm-5">
				      <input type="text" name="r" class="form-control" placeholder="%">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Berapa lama lagi dana dibutuhkan (tahun)</label>
				    <div class="col-sm-5">
				      <input type="text" name="n" class="form-control" placeholder="Tahun">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Uang yang dimiliki saat ini (Rp)</label>
				    <div class="col-sm-5">
				      <input type="text" name="pv" class="form-control" placeholder="Rp">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Target kenaikan investasi per tahun (%)</label>
				    <div class="col-sm-5">
				      <input type="text" name="i" class="form-control" placeholder="%">
				    </div>
				  </div>
				  <button id="calculate" class="btn btn-primary btn-block">Hitung</button>
				</form>
		    </div>
	    </div>
	</div>

	<div class="col-md-6">
		<div class="card mb-4">
	        <div class="card-header">
		        <i class="fas fa-calculator"></i>
		        Result
		    </div>
		    <div class="card-body">
		    	<form id="result" class="hidden">
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Nominal yang harus diinvestasikan per bulan (Rp)</label>
				    <div class="col-sm-5">
				      <input type="text" id="m_pmt" class="form-control-plaintext">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label class="col-sm-7 col-form-label">Nominal yang harus diinvestasikan per tahun (Rp)</label>
				    <div class="col-sm-5">
				      <input type="text" id="y_pmt" class="form-control-plaintext">
				    </div>
				  </div>
				</form>
		    </div>
	    </div>
	</div>
</div>