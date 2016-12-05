<!-- Login wrapper -->
<div class="login-wrapper">
    <form method="post" action="<?php echo site_url('login/dologin')?>" role="form" id="form-login">
        <div class="popup-header">
            <span class="text-semibold"><h3 style="color:#50abc2;">Login</h3></span>
        </div>
        <div class="well">
            <div id="notification-failed" class="form-group bg-danger padding-5 hidden-ul">Login failed!</div>
            <div class="form-group has-feedback">
                <label>Username</label>
                <input name="username" id="username" type="text" class="form-control" placeholder="Username">
                <i class="icon-users form-control-feedback"></i>
            </div>

            <div class="form-group has-feedback">
                <label>Password</label>
                <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="row form-actions">
                <div class="col-xs-6">
                    <div class="checkbox checkbox-success">
                        <label>
                            <input type="checkbox" class="styled">
                            Remember me
                        </label>
                    </div>
                </div>

                <div class="col-xs-6">
                    <button type="submit" class="btn pull-right" style="background-color:#50abc2;"><i class="icon-menu2"></i> Sign in</button>
                </div>
            </div>
        </div>
		<div class="well" style="background-color:$fff;">
			<div class="row">
				<div class="col-xs-12 text-center">
					<span class="text-semibold"><h4 style="color:#009999;">POWERED by:</h4></span>
				</div>
				<div class="clearfix"></div>
				
				<div class="col-xs-6 text-center">
					<img src="<?php echo loadImages()?>/sim_logo.png" alt="Raja Renov" style="width:60%;"> 
				</div>
				<div class="col-xs-6 text-center">
					<img src="<?php echo loadImages()?>/adira_insurance.png" alt="Raja Renov" style="width: 60%; padding-top:10%;"> 
				</div>			
			</div>
        </div>
		
    </form>
</div>
<!-- /login wrapper -->