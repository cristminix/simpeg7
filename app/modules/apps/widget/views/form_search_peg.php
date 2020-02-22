<div class="row" id="div_opsi" style="display:none; padding-top:20px;">
			
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Unit kerja:</label>
													<select id="a_kode_unor" name="a_kode_unor" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($unor as $key=>$val){
																echo '<option value="'.$val->kode_unor.'" '.(isset($param["kode_unor"]) && $param["kode_unor"][0] == $val->kode_unor?"selected":"").'>'.$val->nama_unor.'</option>';															
															}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Status kepegawaian:</label>
													<select id="a_pns" name="a_pns" class="form-control srch" onchange="changeTitleData(1);">
														<option value="all" selected>Semua...</option>
														<option value="kontrak">KONTRAK</option>
														<option value="capeg">CAPEG</option>
														<option value="tetap">TETAP</option>
													</select>
											</div>
											<div class="form-group">
												<label>Pangkat / golongan:</label>
													<select id="a_pangkat" name="a_pangkat" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($pkt as $key=>$val){
																if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}
															}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Jenis jabatan:</label>
													<select id="a_jabatan" name="a_jabatan" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($jbt as $key=>$val){
																if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}
															}
														?>
													</select>
											</div>
										
										
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Gender:</label>
													<select id="a_gender" name="a_gender" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<option value="l">Laki-laki</option>
														<option value="p">Perempuan</option>
													</select>
											</div>
											<div class="form-group">
												<label>Agama:</label>
													<select id="a_agama" name="a_agama" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($agama as $key=>$val){	if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Status perkawinan:</label>
													<select id="a_status" name="a_status" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($status as $key=>$val){	if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Jenjang pendidikan:</label>
													<select id="a_jenjang" name="a_jenjang" class="form-control srch" onchange="changeTitleData(1);">
														<option value="" selected>Semua...</option>
														<?php
															foreach($jenjang as $key=>$val){	if($key!=""){	echo '<option value="'.$val.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
										</div>
									</div>
								</div>
						</div>