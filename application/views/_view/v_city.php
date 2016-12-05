<script type="text/javascript">var vars = <?php echo json_encode($data)?>;</script>
<script type="text/javascript" src="<?php echo backendAsset()?>/js/city.js"></script>
<div class="tab-pane active fade in" id="inside">
    <div class="panel panel-default" id="list">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-paragraph-justify"></i>List City</h6>
            <div class="pull-right">
                <button type="button" class="btn btn-info" id="btn-add"><i class="icon-plus"></i>Add</button>
            </div>
        </div>
        <div class="list-city">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="0">No.</th>
                    <th width="15%">Province</th>
                    <th width="30%">Name</th>
                    <th width="10%">Code</th>
                    <th width="15%">Latitude</th>
                    <th width="15%">Longitude</th>
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form add menu -->
    <div id="add-form">
        <form id="form-add-city" action="<?php echo site_url('master/city')?>" class="validate" role="form" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Add City</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="btn-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="add">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" id="select2">
                                <label>Province:</label>
                                <input type="text" name="province_id" id="add" class="select2-province-id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>City Name</label>
                                <input type="text" name="name" class="required form-control" placeholder="City Name">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Code</label>
                                <input type="text" name="code" class="required form-control" placeholder="Code">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="required form-control" placeholder="Latitude">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="required form-control" placeholder="longitude">
                            </div>

                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                        <input type="submit" value="Save" class="btn btn-primary" id="btn-save">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /form add menu -->

    <!-- Form edit -->
    <div id="edit-form">
        <form id="form-edit-city" action="<?php echo site_url('master/city')?>" class="validate" role="form" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-menu"></i> Edit City</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="btn-edit-cancel"><i class="icon-cancel"></i>Cancel</button>
                    </div>
                </div>
                <input type="hidden" name="type" value="edit">
                <input type="hidden" name="id">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12" id="select2">
                                <label>Province:</label>
                                <input type="text" name="province_id" id="add" class="select2-province-id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>City Name</label>
                                <input type="text" name="name" class="required form-control" placeholder="City Name">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" placeholder="Code">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Latitude</label>
                                <input type="text" name="latitude" class="form-control" placeholder="Latitude">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Longitude</label>
                                <input type="text" name="longitude" class="form-control" placeholder="longitude">
                            </div>

                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <input type="reset" value="Reset" class="btn btn-danger" id="btn-reset">
                        <input type="submit" value="Save" class="btn btn-primary" id="btn-save">
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
                        </i> View City</h6>
                    <div class="pull-right">
                        <button type="button" class="btn btn-info" id="btn-back"><i class="icon-arrow-left"></i>Back</button>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Province Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="province_id"></p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">City Name:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="city_name"></p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Code:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="code"></p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Latitude:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="latitude"></p>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-right">Longitude:</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="longitude"></p>
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
                <form action="<?php echo site_url('master/city');?>" id="form-modal-delete" name="form-modal-delete"  method="post">
                    <div class="modal-header">
                        <button id="btn-dismis" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title"><i class="icon-file-remove"></i>Delete</h3>
                    </div>
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="city_id" value="">
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
