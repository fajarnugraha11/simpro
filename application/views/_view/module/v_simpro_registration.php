<script type="text/javascript">var vars = <?php echo json_encode($data)?>;</script>
<script type="text/javascript" src="<?php echo backendAsset()?>js/simpro_registration.js"></script>

<style>
    label{font-size: 10px;}
    /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   speak for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
    .modal-load {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 )
        url('assets/londinium/images/pIkfp.gif')
        50% 50%
        no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading {
        overflow: hidden;
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal-load {
        display: block;
    }
</style>
<div class="tab-pane active fade in" id="inside">
    <div class="modal-load"><!-- Place at bottom of page --></div>

    <div class="panel panel-default" id="list">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-justify"></i>List Simpro Registration</h6>
            <div class="pull-right">
                <?php if($this->session->userdata('level') != 3){ ?>
					<button type="button" class="btn btn-info" id="btn-add"><i class="icon-plus"></i>Add</button>
				<?php } ?>
				
				<input type="hidden" id="store_id" value="<?php echo $this->session->userdata('level'); ?>"/>
            </div>
        </div>
        <div class="list-simpro" style="overflow: scroll;">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Reg. No</th>
                        <th>Store</th>
                        <th>SIMPRO Category</th>
                        <th>Card Number</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Product</th>
                        <th>Date In</th>
                        <th>Amount</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Form add menu -->
    <div id="add-form">
        <form method="post" id="form-add-simpro" action="<?php echo site_url('simpro_registration')?>" role="form" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Formulir Registrasi</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="btn-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="add">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="pull-right">
                                <span class="subtitle store_name"></span>
                                <input type="hidden" name="store">
                            </div>
                            <span class="subtitle"><i class="icon-accessibility"></i> DATA PELANGGAN</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Nama Lengkap *: </label>
                                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Nama Lengkap" onkeypress="nextfieldBarPress(event, 'card_number', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'card_number', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>No. Kartu Identitas *: </label>
                                            <input type="text" name="card_number" id="card_number" class="form-control" placeholder="No. Kartu Identitas" onkeypress="nextfieldBarPress(event, 'address', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'address', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Alamat *: </label>
                                            <input type="text" name="address" id="address" class="form-control" placeholder="Alamat" onkeypress="nextfieldBarPress(event, 'phone_number', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'phone_number', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <label>No. Telepon *: </label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="No. Telepon" onkeypress="nextfieldBarPress(event, 'contact_number', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'contact_number', 'add-form', this.id)" required>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <label>No. Kontak Lainnya : </label>
                                            <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="No. Kontak Lainnya" onkeypress="nextfieldBarPress(event, 'email_address', 'add-form', this.id)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Alamat Email *: </label>
                                            <input type="text" name="email_address" id="email_address" class="form-control" placeholder="Alamat Email" onkeypress="nextfieldBarPress(event, 'kondisi', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'kondisi', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-tag"></i> Nama Produk</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Merek *: </label>
                                            <input type="text" id="product_id" name="product_id" class="required select2-product-id" placeholder="Pilih Produk" required>
                                        </div>
										<div class="    col-sm-12 col-xs-12">
                                            <label>Tipe Perangkat *: </label>
                                            <input type="text" id="device_type" name="device_type" class="required select2-device-type-id" placeholder="Tipe Perangkat" required>
                                            <input type="hidden" name="product_name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Kondisi Unit *: </label>
                                            <select data-placeholder="Kondisi Unit" name="kondisi" id="kondisi" class="required form-control" tabindex="2" required>
                                                <option value="">Pilih Kondisi</option>
                                                <option value="new">New</option>
                                                <option value="used">Used</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
										<div class="col-sm-12 col-xs-12">
                                            <label>Harga Pertanggungan (Rp.) *: </label>
                                            <input type="text" name="sum_insured" id="sum_insured" class="form-control numeric" placeholder="Harga Pertanggungan" onkeypress="nextfieldBarPress(event, 'imei', 'add-form', this.id)"  onKeyUp="nextfieldBar(event, 'imei', 'add-form', this.id)" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Kategori SIMPRO *: </label>
                                            <input type="text" name="simpro_category" id="simpro_category" class="form-control" readonly placeholder="Kategori SIMPRO" onkeypress="nextfieldBarPress(event, 'imei', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'imei', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>IMEI *: </label>
                                            <input type="text" name="imei" id="imei" class="form-control" maxlength="15" placeholder="IMEI" onkeypress="nextfieldBarPress(event, 'purchase_date', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'purchase_date', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <label>Periode Awal *: </label>
                                            <input type="text" name="product_period_start" id="product_period_start" class="form-control" placeholder="Periode Awal" readonly required>
                                        </div>

                                        <div class="col-sm-6 col-xs-6">
                                            <label>Periode Akhir</label>
                                            <input type="text" name="product_period_end" id="product_period_end" class="form-control" readonly placeholder="Periode Akhir" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <label>Tanggal Pembelian: </label>
                                            <input type="text" name="purchase_date" id="purchase_date" class="form-control" placeholder="Tanggal Pembelian" required="" onkeypress="nextfieldBarPress(event, 'has_payment', 'add-form', this.id)">
                                        </div>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
										    <label>Payment Amount (Rp.) *: </label>
                                            <input type="checkbox" class="styled form-control" value="1" name="has_payment" id="has_payment" onkeypress="nextfieldBarPress(event, 'payment_amount', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'payment_amount', 'add-form', this.id)">Payment
                                            <input type="text" name="payment_amount" id="payment_amount" class="required form-control numeric" placeholder="Payment Amount" onkeypress="nextfieldBarPress(event, 'bukti_pembelian_y', 'add-form', this.id)" onkeyup="nextfieldBar(event, 'bukti_pembelian_y', 'add-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-copy"></i> Dokumen</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>1. Bukti Pembelian: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="bukti_pembelian" id="bukti_pembelian_y" value="Y" onkeypress="nextfieldBarPress(event, 'kartu_garansi_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="bukti_pembelian" id="bukti_pembelian_n" value="N" onkeypress="nextfieldBarPress(event, 'kartu_garansi_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>2. Kartu Garansi: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="kartu_garansi" id="kartu_garansi_y" value="Y" onkeypress="nextfieldBarPress(event, 'kartu_identitas_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="kartu_garansi" id="kartu_garansi_n" value="N" onkeypress="nextfieldBarPress(event, 'kartu_identitas_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>3. Kartu Identitas: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="kartu_identitas" id="kartu_identitas_y" value="Y" onkeypress="nextfieldBarPress(event, 'voucher_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="kartu_identitas" id="kartu_identitas_n" value="N" onkeypress="nextfieldBarPress(event, 'voucher_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>4. Voucher: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="voucher" id="voucher_y" value="Y" onkeypress="nextfieldBarPress(event, 'is_warranty_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="voucher" id="voucher_n" value="N" onkeypress="nextfieldBarPress(event, 'is_warranty_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
										<div class="col-sm-12 col-xs-12" style="margin-top:7px">
                                            <hr/>
											<label>Is Warranty: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="is_warranty" id="is_warranty_y" value="Y" onkeypress="nextfieldBarPress(event, 'unit_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="is_warranty" id="is_warranty_n" value="N" onkeypress="nextfieldBarPress(event, 'unit_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-checkmark4"></i> Check Point</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>1. Unit: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="unit" id="unit_y" value="Y" onkeypress="nextfieldBarPress(event, 'cover_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="unit" id="unit_n" value="N" onkeypress="nextfieldBarPress(event, 'cover_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>2. Cover: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="cover" id="cover_y" value="Y" onkeypress="nextfieldBarPress(event, 'battery_y', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="cover" id="cover_n" value="N" onkeypress="nextfieldBarPress(event, 'battery_y', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>3. Battery: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="battery" id="battery_y" value="Y" onkeypress="nextfieldBarPress(event, 'other', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="battery" id="battery_n" value="N" onkeypress="nextfieldBarPress(event, 'other', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>4. Other: </label>
                                            <div class="block-inner">
                                                <input type="text" name="other" id="other" class="form-control" onkeypress="nextfieldBarPress(event, 'is_seal_y', 'add-form', this.id)">
                                            </div>
                                        </div>

										<div class="col-sm-12 col-xs-12">
                                            <hr/>
											<label>Is Seal: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="is_seal" id="is_seal_y" value="Y" onkeypress="nextfieldBarPress(event, 'btn-save', 'add-form', this.id)">&nbsp;Y
                                                <input type="radio" name="is_seal" id="is_seal_n" value="N" onkeypress="nextfieldBarPress(event, 'btn-save', 'add-form', this.id)">&nbsp;N
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-actions text-right">
                                <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                                <input type="button" value="Register" class="btn btn-primary" id="btn-save">
                            </div>
                        </div>
                    </div>
                </div>
			</form>
		</div>
    </div>
    <!-- /form add menu -->
    <!-- Form edit -->
    <div id="edit-form">
        <form method="post" id="form-edit-simpro" action="<?php echo site_url('simpro_registration')?>" role="form" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Edit Data Registration</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="btn-back"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="edit">
                <input type="hidden" name="id">
                <input type="hidden" name="reg_no">
                <input type="hidden" name="date_in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="pull-right">
                                <span class="subtitle store_name"></span>
                                <input type="hidden" name="store">
                            </div>
                            <span class="subtitle"><i class="icon-accessibility"></i> DATA PELANGGAN</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Nama Lengkap *: </label>
                                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Nama Lengkap" onkeypress="nextfieldBarPress(event, 'card_number', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'card_number', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>No. Kartu Identitas *: </label>
                                            <input type="text" name="card_number" id="card_number" class="form-control" placeholder="No. Kartu Identitas" onkeypress="nextfieldBarPress(event, 'address', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'address', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Alamat *: </label>
                                            <input type="text" name="address" id="address" class="form-control" placeholder="Alamat" onkeypress="nextfieldBarPress(event, 'phone_number', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'phone_number', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <label>No. Telepon *: </label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="No. Telepon" onkeypress="nextfieldBarPress(event, 'contact_number', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'contact_number', 'edit-form', this.id)" required>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <label>No. Kontak Lainnya : </label>
                                            <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="No. Kontak Lainnya" onkeypress="nextfieldBarPress(event, 'email_address', 'edit-form', this.id)" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Alamat Email *: </label>
                                            <input type="text" name="email_address" id="email_address" class="form-control" placeholder="Alamat Email" onkeypress="nextfieldBarPress(event, 'kondisi', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'kondisi', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-tag"></i> Nama Produk</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Merek *: </label>
                                            <input type="text" id="product_id" name="product_id" class="required select2-product-id" placeholder="Pilih Produk" required>
                                        </div>
                                        <div class="    col-sm-12 col-xs-12">
                                            <label>Tipe Perangkat *: </label>
                                            <input type="text" id="device_type" name="device_type" class="required select2-device-type-id" placeholder="Tipe Perangkat" required>
                                            <input type="hidden" name="product_name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Kondisi Unit *: </label>
                                            <select data-placeholder="Kondisi Unit" name="kondisi" id="kondisi" class="required form-control" tabindex="2" required>
                                                <option value="">Pilih Kondisi</option>
                                                <option value="new">New</option>
                                                <option value="used">Used</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Harga Pertanggungan (Rp.) *: </label>
                                            <input type="text" name="sum_insured" id="sum_insured" class="form-control numeric" placeholder="Harga Pertanggungan" onkeypress="nextfieldBarPress(event, 'imei', 'edit-form', this.id)"  onKeyUp="nextfieldBar(event, 'imei', 'edit-form', this.id)" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Kategori SIMPRO *: </label>
                                            <input type="text" name="simpro_category" id="simpro_category" class="form-control" readonly placeholder="Kategori SIMPRO" onkeypress="nextfieldBarPress(event, 'imei', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'imei', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>IMEI *: </label>
                                            <input type="text" name="imei" id="imei" class="form-control" maxlength="15" placeholder="IMEI" onkeypress="nextfieldBarPress(event, 'purchase_date1', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'purchase_date1', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <label>Periode Awal *: </label>
                                            <input type="text" name="product_period_start" id="product_period_start" class="form-control" placeholder="Periode Awal" readonly required>
                                        </div>

                                        <div class="col-sm-6 col-xs-6">
                                            <label>Periode Akhir</label>
                                            <input type="text" name="product_period_end" id="product_period_end" class="form-control" readonly placeholder="Periode Akhir" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <label>Tanggal Pembelian: </label>
                                            <input type="text" name="purchase_date" id="purchase_date1" class="form-control" placeholder="Tanggal Pembelian" required="" onkeypress="nextfieldBarPress(event, 'has_payment', 'edit-form', this.id)">
                                        </div>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <label>Payment Amount (Rp.) *: </label>
                                            <input type="checkbox" class="styled form-control" value="1" name="has_payment" id="has_payment" onkeypress="nextfieldBarPress(event, 'payment_amount', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'payment_amount', 'edit-form', this.id)">Payment
                                            <input type="text" name="payment_amount" id="payment_amount" class="required form-control numeric" placeholder="Payment Amount" onkeypress="nextfieldBarPress(event, 'bukti_pembelian_y', 'edit-form', this.id)" onkeyup="nextfieldBar(event, 'bukti_pembelian_y', 'edit-form', this.id)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-copy"></i> Dokumen</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>1. Bukti Pembelian: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="bukti_pembelian" id="bukti_pembelian_y" value="Y" onkeypress="nextfieldBarPress(event, 'kartu_garansi_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="bukti_pembelian" id="bukti_pembelian_n" value="N" onkeypress="nextfieldBarPress(event, 'kartu_garansi_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>2. Kartu Garansi: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="kartu_garansi" id="kartu_garansi_y" value="Y" onkeypress="nextfieldBarPress(event, 'kartu_identitas_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="kartu_garansi" id="kartu_garansi_n" value="N" onkeypress="nextfieldBarPress(event, 'kartu_identitas_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>3. Kartu Identitas: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="kartu_identitas" id="kartu_identitas_y" value="Y" onkeypress="nextfieldBarPress(event, 'voucher_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="kartu_identitas" id="kartu_identitas_n" value="N" onkeypress="nextfieldBarPress(event, 'voucher_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>4. Voucher: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="voucher" id="voucher_y" value="Y" onkeypress="nextfieldBarPress(event, 'is_warranty_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="voucher" id="voucher_n" value="N" onkeypress="nextfieldBarPress(event, 'is_warranty_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12" style="margin-top:7px">
                                            <hr/>
                                            <label>Is Warranty: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="is_warranty" id="is_warranty_y" value="Y" onkeypress="nextfieldBarPress(event, 'unit_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="is_warranty" id="is_warranty_n" value="N" onkeypress="nextfieldBarPress(event, 'unit_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <span class="subtitle"><i class="icon-checkmark4"></i> Check Point</span>
                            <div class="well">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>1. Unit: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="unit" id="unit_y" value="Y" onkeypress="nextfieldBarPress(event, 'cover_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="unit" id="unit_n" value="N" onkeypress="nextfieldBarPress(event, 'cover_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>2. Cover: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="cover" id="cover_y" value="Y" onkeypress="nextfieldBarPress(event, 'battery_y', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="cover" id="cover_n" value="N" onkeypress="nextfieldBarPress(event, 'battery_y', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>3. Battery: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="battery" id="battery_y" value="Y" onkeypress="nextfieldBarPress(event, 'other', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="battery" id="battery_n" value="N" onkeypress="nextfieldBarPress(event, 'other', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <label>4. Other: </label>
                                            <div class="block-inner">
                                                <input type="text" name="other" id="other" class="form-control" onkeypress="nextfieldBarPress(event, 'is_seal_y', 'edit-form', this.id)">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <hr/>
                                            <label>Is Seal: </label>
                                            <div class="block-inner">
                                                <input type="radio" name="is_seal" id="is_seal_y" value="Y" onkeypress="nextfieldBarPress(event, 'btn-save-edit', 'edit-form', this.id)">&nbsp;Y
                                                <input type="radio" name="is_seal" id="is_seal_n" value="N" onkeypress="nextfieldBarPress(event, 'btn-save-edit', 'edit-form', this.id)">&nbsp;N
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
						

					<div class="clearfix"></div>
                    <div class="form-actions text-right">
                        <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                        <input type="button" value="Edit" class="btn btn-primary" id="btn-save-edit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form edit -->
    <!-- Form view -->
    <div id="view-form">
        <div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title"><i class="icon-coin"></i> View Registration</h6>
				<div class="pull-right">
					<button type="button" class="btn btn-info" id="btn-edit-cancel"><i class="icon-cancel"></i>Cancel</button>
				</div>
				<div class="dropdown pull-right">					
					<a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown">
						<i class="icon-cog3"></i> 
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu icons-right dropdown-menu-right">
						<li><a href="#"><i class="icon-print2"></i> Print invoice</a></li>
						<!--
							<li><a href="#"><i class="icon-download"></i> Download invoice</a></li>
							<li><a href="#"><i class="icon-file-pdf"></i> View .pdf</a></li>
							<li><a href="#"><i class="icon-stack"></i> Archive</a></li>
						-->
					</ul>
				</div>
			</div>

			<div class="panel-body">

				<div class="row invoice-header">
					<div class="col-sm-6">
						<h3>SIMPRO</h3>
						<span><i>Protection for your device</i></span>
					</div>

					<div class="col-sm-6">
						<ul class="invoice-details">
							<li>Reg No. # <strong class="text-danger"><p class="form-control-static" id="reg_no"></p></strong></li>
							<li>Store: <strong><p class="form-control-static" id="store_name"></p></strong></li>
							<li>Date In: <strong><p class="form-control-static" id="date_in"></p></strong></li>
							<li>Current status: <p class="label pull-right" id="status">Paid</p></li>
						</ul>
					</div>
				</div>


				<div class="row">
					<div class="col-sm-12">
						<span class="subtitle"><i class="icon-accessibility"></i> DATA PELANGGAN/<font style="font-style:italic;">Customer Profile</font></span>						
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label text-left">Nama Lengkap</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="full_name"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">No. Kartu Identitas</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="card_number"></p>
								</div>									
							</div>							
							<div class="clearfix"></div>							
							<div class="form-group">
								<label class="col-sm-2 control-label text-left">Alamat</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="address"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">Alamat Email</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="email_address"></p>
								</div>									
							</div>							
							<div class="clearfix"></div>							
							<div class="form-group">
								<label class="col-sm-2 control-label text-left">No. Telepon</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="phone_number"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">No. Kontak Lainya</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="contact_number"></p>
								</div>									
							</div>							
							<div class="clearfix"></div>							
							<div class="form-group">
								<label class="col-sm-2 control-label text-left">Kategori SIMPRO</label>
								<div class="col-sm-10">
									<p class="form-control-static" id="simpro_category"></p>
								</div>																	
							</div>								
						</div>
						<hr/>
					</div>


					<div class="col-sm-6">
						<span class="subtitle"><i class="icon-tag"></i> Nama Produk/<font style="font-style:italic;">Product Name</font></span>					
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label text-left">Merek</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="brand"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">Harga Pertanggungan</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="sum_insured"></p>
								</div>								
								
								<div class="clearfix"></div>
								
								<label class="col-sm-2 control-label text-left">Tipe Perangkat</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="device_type"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">IMEI</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="imei"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-2 control-label text-left">Periode Produk Mulai</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="product_period_start"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">Periode Produk Berakhir</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="product_period_end"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-2 control-label text-left">Tanggal Pembelian</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="purchase_date"></p>
								</div>
								
								<label class="col-sm-2 control-label text-left">Total Biaya</label>
								<div class="col-sm-4">
									<p class="form-control-static" id="payment_amount"></p>
								</div>
								
							</div>							
						</div>
					</div>
					
					<div class="col-sm-3">
						<span class="subtitle"><i class="icon-copy"></i> Dokumen/<font style="font-style:italic;">Document</font></span>					
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-5 control-label text-left">Bukti Pembelian</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="bukti_pembelian"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Kartu Garansi</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="kartu_garansi"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Kartu Identitas</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="kartu_identitas"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Voucher</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="voucher"></p>
								</div>
								
							</div>						
						</div>
					</div>
					
					<div class="col-sm-3">
						<span class="subtitle"><i class="icon-checkmark4"></i> Check Point</span>				
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-5 control-label text-left">Unit</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="unit"></p>
								</div>		
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Cover</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="cover"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Battery</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="battery"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">Other</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="other"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">WARRANTY</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="is_warranty"></p>
								</div>
								
								<div class="clearfix"></div>
								
								<label class="col-sm-5 control-label text-left">SEAL</label>
								<div class="col-sm-5">
									<p class="form-control-static" id="is_seal"></p>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="row invoice-payment">
					<div class="col-sm-4 col-sm-offset-8">						
						<table class="table">
							<tbody>
								<tr>
									<th>Total:</th>
									<td class="text-right text-danger"><h6 id="total_amount"></h6></td>
								</tr>
							</tbody>
						</table>
						<div class="btn-group pull-right">
							<a id="print_url" target="_blank" href="" class="btn btn-primary"><i class="icon-print2"></i> Print</a>
						</div>
					</div>
				</div>

				<h6>Notes &amp; Information:</h6>
				This invoice contains a incomplete list of items destroyed by the Federation ship Enterprise on Startdate 5401.6 in an unprovked attacked on a peaceful &amp; wholly scientific mission to Outpost 775.
				The Romulan people demand immediate compensation for the loss of their Warbird, Shuttle, Cloaking Device, and to a lesser extent thier troops.
			</div>
		</div>
    </div>
    <!-- /form view -->
</div>
<div class="hide">
    <a id="notification-succes" onclick="$.jGrowl('Everything is fine', { theme: 'growl-success', header: 'Success!' });">Success notification</a>
    <a id="notification-error" onclick="$.jGrowl('Sorry, cannot remove Simpro. <br/> It\'s still have Sub Menu and Access Menu.', { theme: 'growl-error', header: 'Error!' });">Error notification</a>
    <a id="notification-warning" onclick="$.jGrowl('Max file size 2Mb', {theme: 'growl-warning', header: 'File to large' });">Warning notification</a>
</div>
<div class="for-modal">
    <!-- Delete modal -->
    <div id="delete_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?php echo site_url('simpro_registration');?>" id="form-modal-delete" name="form-modal-delete" method="post">
                    <div class="modal-header">
                        <button id="btn-dismis" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><i class="icon-file-remove"></i>Delete Registration</h3>
                    </div>
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="simpro_id" value="">
                    <input type="hidden" name="reg_no" value="">
                    <div class="modal-body with-padding">
                        <p>Are you sure want to delete <i id="label-name"></i> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" data-dismiss="modal">No</button>
                        <button type="submit" id="btn-modal-delete" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /delete modal -->
</div>