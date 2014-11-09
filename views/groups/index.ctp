
<!--<div class="row down-row">
        <nav class="navbar navbar-default navbar-fixed-top down-nav " role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">toggle navigation </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
            </div>
            <div class="container">
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav nav-tabs">
                        
                        <li class="active"><a href="<?php // echo Router::url(array('action'=>'index')) ?>">all</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'users',$id)) ?>">users</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'lecture')) ?>">lecture</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'request')) ?>">request</a></li>
                    </ul>
                </div>
            </div>
        </nav>
</div>-->

<div>
    <ul class="nav nav-tabs" style="margin-left:0;" id="myTab">
        <li class="active"><a  data-toggle="tab" href="#view_posts" >Discussion</a></li>
        <li><a data-toggle="tab" href="#users">Users</a></li>
        <li><a data-toggle="tab" href="#uploads">Uploads</a></li>
        <li><a data-toggle="tab" href="#group_info">Info</a></li>
        </li>
    </ul>
    <script>
        $('#myTab a').click(function(){
            var trgt=$(this).attr('href');
            if(trgt=='#uploads'){
                $(trgt).load("<?php echo Router::url(array('controller' => 'uploads','action'=>'index',$id)) ;?>/");
            }else{
                $(trgt).load("<?php echo Router::url(array('controller' => 'groups')) ;?>/"+trgt.substring(1)+"/<?php echo $id;?>");
            }
        });            
        setTimeout(function(){   
            $('#myTab a[href="#view_posts"]').trigger('click');
        },1);

    </script>
    <div class="tab-content" id="myTabContent">
        <div id="view_posts" class="tab-pane fade in active">

        </div>
        <div id="users" class="tab-pane fade in">
            
        </div>
        <div id="uploads" class="tab-pane fade in">
            
        </div>
        <div id="group_info" class="tab-pane fade in" >
            
        </div>
    </div>
</div>