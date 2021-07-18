     
     <form action=" /index.php" method="get">

          <div class="modal fade" id="modal-exit" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content bg-danger">
                <div class="modal-header">
                  <h4 class="modal-title">Уверены что хотите закрыть смену?</h4>
                  
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>

                <div class="modal-body">
                  <p>
                  <small>Будут недоступны уведомления предыдущей смены.</small>
                  </p>
                </div>

                <div class="modal-footer justify-content-between">
                <input type="hidden" id="exit" value='1' name="exit">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">выйти</button>
                  <button type="submit" class="btn btn-outline-light">Закрыть смену</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        </form>   
<script type="text/javascript">
  function showMessage10() {

    $('#modal-exit').modal({show:true});
}

</script>