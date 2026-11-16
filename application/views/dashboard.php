<!-- Basic Layout -->

<div class="row">

    <div class="col-lg-8 mb-4 order-0">

      <div class="card">

        <div class="d-flex align-items-end row">

          <div class="col-sm-7">

            <div class="card-body">

              <h5 class="card-title text-primary">Hai, Selamat Datang!! 🎉</h5>

              <p class="mb-4">

                <?php if ($numlist > 0) {

                  echo 'Kamu sedang ada <span class="fw-bold">'.$numlist.'</span> pengiriman hari ini. Cek sekarang!.';

                }else{ 

                  echo 'Tidak ada pengiriman hari ini!';

                }?>

              </p>

              <?php 

              if ($this->session->userdata('s_usr_role') != 3){

                $link = base_url('delivery_list');

              }else{

                $link = base_url('driver_anterin');

              } ?>

              <a href="<?= $link; ?>" class="btn btn-sm btn-outline-info">Lihat!</a>

            </div>

          </div>

          <div class="col-sm-5 text-center text-sm-left">

            <div class="card-body pb-0 px-0 px-md-4">

              <img

                src="<?= config_item('img'); ?>/illustrations/man-with-laptop-light.png"

                height="140"

                alt="View Badge User"

                data-app-dark-img="illustrations/man-with-laptop-dark.png"

                data-app-light-img="illustrations/man-with-laptop-light.png"

              />

            </div>

          </div>

        </div>

      </div>

    </div>

</div>