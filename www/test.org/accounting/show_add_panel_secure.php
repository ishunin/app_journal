<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Дополнительная панель:
        </h3>
    </div>
    <div class="card-body">
        <!--  <h4>Custom Content Below</h4>-->
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px" ;="">
            <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
            </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12">
                        <?php show_comments($link, 'об', 10); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                <span class="my_changes_text">
                    <?php
                    echo (show_changes_ob($link, $link_account));
                    ?>

                    </p>
                </span>
            </div>
        </div>
        <!-- /.card -->