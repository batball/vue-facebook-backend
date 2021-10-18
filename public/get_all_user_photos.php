<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */

use App\Controllers\GetAllUserPhotosController;

require_once 'index.php';

(new GetAllUserPhotosController())->__invoke();