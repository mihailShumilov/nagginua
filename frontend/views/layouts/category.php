<?= $this->render( '_parts/head' ) ?>

    <!-- Body Wrapper -->
    <div class="body-wrapper">
        <div class="controller">
            <div class="controller2">

                <!-- Header -->
                <?= $this->render( '_parts/header' ) ?>

                <!-- /Header -->


                <!-- Content -->
                <section id="content">
                    <div class="container">
                        <!-- Main Content -->

                        <?= $this->render( '_parts/breadCrumbs' ) ?>

                        <div class="main-content">

                            <!-- Popular News -->
                            <?= $content; ?>
                            <!-- /Popular News -->

                        </div>
                        <!-- /Main Content -->

                        <!-- Left Sidebar -->
                        <?= $this->render( '_parts/sidebar', [ ] ) ?>

                        <!-- /Left Sidebar -->

                    </div>
                </section>
                <!-- / Content -->

                <!-- Footer -->
                <?= $this->render( '_parts/footer' ) ?>

                <!-- / Footer -->

            </div>
        </div>
    </div>
    <!-- / Body Wrapper -->


<?= $this->render( '_parts/foot' ) ?>