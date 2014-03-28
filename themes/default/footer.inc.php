                            </div>
                            <div class="col-md-2"><br>
                                <?php $this->widgetOutput('sidebarRight');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                if(defined("DEBUG_MODE") && DEBUG_MODE == 1){
                    $timer->stop();
                    echo " This page took ".$timer->retrieve()." milliseconds to load.";
                }
                ?>
            
        </div>
        <div class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <p class="navbar-text pull-left">© 2014 - Site Built By darkfr3ak | 
                    <!--<a href="http://html5.validator.nu/?doc=http%3A%2F%2Fdarkfr3ak.pf-control.de%2F" target="_blank">HTML 5 Validation</a>-->
                    <a href="http://html5.validator.nu/?doc=http%3A%2F%2Fdarkfr3ak.pf-control.de%2F" target="_blank">
                        <img src="http://www.w3.org/html/logo/badge/html5-badge-h-css3-semantics.png" height="32" alt="HTML5 Powered with CSS3 / Styling, and Semantics" title="HTML5 Powered with CSS3 / Styling, and Semantics">
                    </a>
                </p>
            </div>
        </div>    
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/jquery-1.11.0.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap-datepicker.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $this->getCurrentTemplatePath();?>js/jquery-ui-1.10.4.custom.js"></script>
        <script src="<?php echo $this->getCurrentApp();?>js/script.js"></script>
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("active");
            });
            $('.input-daterange').datepicker({
                todayBtn: "linked",
                language: "de",
                todayHighlight: true
            });
            $(document).ready(function(){ 
                $(function() {
                    $('.draggable-list').sortable({
                        connectWith: '.draggable-list',
                        update: function (event, ui) {
                            var data = "wid=>" + $(this).sortable('toArray').toString() + "|pos=>" + this.id + ";";
                            if(this.id != "avail_list"){
                                $('#qrystr').val($('#qrystr').val() + data);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
