<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */
require_once 'index.php';

use App\Controllers\SaveUserSelectedPhotosController;


(new SaveUserSelectedPhotosController())->__invoke();