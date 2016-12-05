<script type="text/javascript">var vars = <?php echo json_encode($data)?>;</script>
<script type="text/javascript" src="<?php echo backendAsset()?>/js/member.js"></script>
<div class="tab-pane active fade in" id="inside">
    <div class="panel panel-default" id="list">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-justify"></i>List Member</h6>
            <div class="pull-right">
                <button type="button" class="btn btn-black" id="btn-add"><i class="icon-plus"></i>Add</button>
            </div>
        </div>
        <div class="list-member">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="0">No.</th>
                    <th width="20%">Usergroup</th>
                    <th width="20%">Email</th>
                    <th width="20%">Name</th>
                    <th width="20%">Created</th>
                    <th width="20%">Action</th>
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form add menu -->
    <div id="add-form">
        <form id="form-add-member" action="<?php echo site_url('member');?>" role="form" class="validate" enctype="multipart/form-data">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><i class="icon-user"></i> Add Member</h6>
                <div class="pull-right">
                    <button type="button" class="btn btn-black" id="btn-cancel"><i class="icon-cancel"></i>Cancel</button>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" name="type" value="add">
                <div class="block-inner">
                    <div class="form-group" id="select2">
                        <label>Usergroup: </label>
                        <input type="text" name="usergroup" class="required select2-usergroup">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <label>Name:</label>
                                <input type="text" name="name" class="required form-control" placeholder="Name">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email address:</label>
                                <input type="text" name="email" class="required form-control" placeholder="your@email.com">
                            </div>

                            <div class="col-md-6">
                                <label>Password:</label>
                                <input type="password" name="password" class="required form-control" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Phone Number:</label>
                                <input type="text" name="telephone" placeholder="9999-9999-9999"  class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Handphone:</label>
                                <input type="text" name="handphone" placeholder="9999-9999-9999"  class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date of birth:</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select data-placeholder="Month" name="month" class="required select-month select-full" tabindex="2">
                                            <option value=""></option>
                                            <?php for($bln = 1;$bln <=12;$bln++){ switch($bln){ case "1":$bulan = "Januari";break;case "2":$bulan = "Februari";break;case "3":$bulan = "Maret";break;case "4":$bulan = "April";break;case "5":$bulan = "Mei";break;case "6":$bulan = "Juni";break;case "7":$bulan = "Juli";break;case "8":$bulan = "Agustus";break;case "9":$bulan = "September";break;case "10":$bulan = "Oktober";break;case "11":$bulan = "November";break;case "12":$bulan = "Desember";break;}?>
                                                <option value="<?php echo $bln; ?>"><?php echo $bulan; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select data-placeholder="Day" name="day" class="required select-day select-full" tabindex="2">
                                            <option value=""></option>
                                            <?php for($tgl = 01;$tgl <= 31;$tgl++){?>
                                                <option value="<?php echo $tgl?>" ><?php echo $tgl; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select data-placeholder="Year" name="year" class="required select-year select-full" tabindex="2">
                                            <option value=""></option>
                                            <?php $now = date("Y");$max = $now - 24;for($thn = $now;$thn >=1913;$thn--){?>
                                                <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender:</label>
                                    <div>
                                        <label class="radio-inline" id="radio-male">
                                            <input type="radio" name="gender" value="Male" class="required styled" checked="checked">
                                            Male
                                        </label>

                                        <label class="radio-inline" id="radio-female">
                                            <input type="radio" name="gender" value="Female" class="required styled">
                                            Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>City:</label>
                            <input type="text" name="city" class="required select2-city">
                        </div>

                        <div class="col-md-6">
                            <label>ZIP Code:</label>
                            <input type="text" name="zipcode" class="form-control" placeholder="Zip Code">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Address information:</label>
                            <textarea rows="5" name="address" cols="5" placeholder="Address information" class="elastic form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group hide">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Photo:</label>
                            <input type="file" name="photo" class="styled" id="">
                            <span class="help-block">Accepted formats: jpg, png. Max file size 500Kb</span>
                        </div>
                    </div>
                </div>
                <div class="form-actions text-right">
                    <input type="submit" value="Save" class="btn btn-primary">
                </div>
            </div>
            </div>
        </form>
    </div>
    <!-- /form add menu -->

    <!-- Form edit -->
    <div id="edit-form">
        <form id="form-edit-member" action="<?php echo site_url('member');?>" role="form" class="validate" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-user"></i> Edit Member</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-edit-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="type" value="edit">
                    <input type="hidden" name="id">
                    <div class="block-inner">
                        <div class="form-group" id="select2">
                            <label>Usergroup: </label>
                            <input type="text" name="usergroup" class="required select2-usergroup">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                    <label>Name:</label>
                                    <input type="text" name="name" class="required form-control" placeholder="Name">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email address:</label>
                                    <input type="text" name="email" class="required form-control" placeholder="your@email.com">
                                </div>

                                <div class="col-md-6">
                                    <label>Password:</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone Number:</label>
                                    <input type="text" name="telephone" placeholder="9999-9999-9999"  class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Handphone:</label>
                                    <input type="text" name="handphone" placeholder="9999-9999-9999"  class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Date of birth:</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select id="select-month" data-placeholder="Month" name="month" class="required select-full" tabindex="2">
                                                <option value=""></option>
                                                <?php for($bln = 1;$bln <=12;$bln++){ switch($bln){ case "1":$bulan = "Januari";break;case "2":$bulan = "Februari";break;case "3":$bulan = "Maret";break;case "4":$bulan = "April";break;case "5":$bulan = "Mei";break;case "6":$bulan = "Juni";break;case "7":$bulan = "Juli";break;case "8":$bulan = "Agustus";break;case "9":$bulan = "September";break;case "10":$bulan = "Oktober";break;case "11":$bulan = "November";break;case "12":$bulan = "Desember";break;}?>
                                                    <option value="<?php echo $bln; ?>"><?php echo $bulan; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <select id="select-day" data-placeholder="Day" name="day" class="required select-full" tabindex="2">
                                                <option value=""></option>
                                                <?php for($tgl = 01;$tgl <= 31;$tgl++){?>
                                                    <option value="<?php echo $tgl?>" ><?php echo $tgl; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <select id="select-year" data-placeholder="Year" name="year" class="required select-full" tabindex="2">
                                                <option value=""></option>
                                                <?php $now = date("Y");$max = $now - 24;for($thn = $now;$thn >=1913;$thn--){?>
                                                    <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gender:</label>
                                        <div>
                                            <label class="radio-inline" id="radio-male">
                                                <input type="radio" name="gender" value="Male" class="styled" checked="checked">
                                                Male
                                            </label>

                                            <label class="radio-inline" id="radio-female">
                                                <input type="radio" name="gender" value="Female" class="required styled">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>City:</label>
                                <input type="text" name="city" class="required select2-city">
                            </div>

                            <div class="col-md-6">
                                <label>ZIP Code:</label>
                                <input type="text" name="zipcode" class="form-control" placeholder="Zip Code">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Address information:</label>
                                <textarea rows="5" id="textarea_address" name="address" cols="5" placeholder="Address information" class="elastic form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group hide">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Photo:</label>
                                <input type="file" name="photo" class="styled" id="">
                                <span class="help-block">Accepted formats: jpg, png. Max file size 500Kb</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <input type="submit" value="Save" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form edit -->

    <!-- Form view -->
    <div id="view-form">
        <form class="form-horizontal" action="#" role="form">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title"><i class="icon-paragraph-justify2">
                        </i> View Member</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-black" id="btn-back"><i class="icon-arrow-left"></i>Back</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Usergroup Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="usergroup_name"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="name"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Email:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="email"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Phone Number:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="phonenumber"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Handphone:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="handphone"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Birthday:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="birthday"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Gender:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="gender"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">City:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="city"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Zipcode:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="zipcode"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Address:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="address"></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form view -->
</div>

<div class="hide">
    <a id="notification-succes" onclick="$.jGrowl('Everything is fine', { theme: 'growl-success', header: 'Success!' });">Success notification</a>
    <a id="notification-error" onclick="$.jGrowl('Sorry, cannot remove. <br/> It\'s still have relation with another table.', { theme: 'growl-error', header: 'Error!' });">Error notification</a>
</div>

<div class="for-modal">
    <!-- Delete modal -->
    <div id="delete_modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?php echo site_url('member');?>" id="form-modal-delete" name="form-modal-delete"  method="post">
                    <div class="modal-header">
                        <button id="btn-dismis" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><i class="icon-file-remove"></i>Delete</h3>
                    </div>
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="id" value="">
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
