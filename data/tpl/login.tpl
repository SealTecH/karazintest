{extends file="main.tpl"}
{block name="body"}
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Sign In</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#"
                                                                                               data-toggle="modal"
                                                                                               data-target=".reset-password-modal">Forgot
                            password?</a></div>
                </div>

                <div style="padding:30px" class="panel-body">

                    <form id="loginform" class="form-horizontal" role="form" data-toggle="validator">

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="email" class="form-control" name="email" value=""
                                       placeholder="E-mail" data-error="invalid e-mail format" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password"
                                       placeholder="Password" required>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>


                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->

                            <div class="col-sm-12 controls">
                                <a id="btn-login" href="#" class="btn btn-success"
                                   onclick="window.User.login($('#login-username').val(),$('#login-password').val());">Login</a>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                    Don't have an account?
                                    <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                        Sign Up Here
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <div id="signupbox" style="display:none; margin-top:50px"
             class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Sign Up</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#"
                                                                                               onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign
                            In</a></div>
                </div>
                <div class="panel-body">
                    <form id="signupform" class="form-horizontal" data-toggle="validator" role="form">

                        <div id="signupalert" style="display:none" class="alert alert-danger">
                            <p>Error:</p>
                            <span></span>
                        </div>


                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>

                            <div class="col-md-9">
                                <input type="email" id="sn-email" class="form-control" name="email"
                                       placeholder="Email Address" data-error="invalid e-mail format" required>

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-md-3 control-label">First Name</label>

                            <div class="col-md-9">
                                <input type="text" id="sn-name" class="form-control" name="firstname"
                                       placeholder="First Name" required>

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="col-md-3 control-label">Last Name</label>

                            <div class="col-md-9">
                                <input type="text" id="sn-lastname" class="form-control" name="lastname"
                                       placeholder="Last Name">

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-3 control-label">Password</label>

                            <div class="col-md-9">
                                <input type="password" id="sn-password" class="form-control" name="passwd"
                                       placeholder="Password" data-error="6 characters min." data-minlength="6"
                                       required>

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-md-offset-3 col-md-9">
                                <button id="btn-signup" type="button" class="btn btn-info"
                                        onclick="window.User.signup($('#sn-email').val(), $('#sn-password').val(), $('#sn-name').val(), $('#sn-lastname').val());">
                                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;Sign Up
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!--password reset modal-->
    <div class="modal fade reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="rp-modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reset password</h4>
                </div>
                <div class="modal-body" id="reset-password">
                    <form data-toggle="validator" method="GET" action="api/user/reset" role="form">
                        <div class="form-group">
                            <div class="input-group">
                          <span class="input-group-btn">
                            <input type="submit" class="btn btn-default">Reset password</button>
                          </span>
                                <input name="email" type="email" class="form-control" id="share-email"
                                       placeholder="E-mail" data-error="Invalid e-mail format." required>
                            </div>
                            <span class="help-block with-errors"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}