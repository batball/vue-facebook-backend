<?php
/**
 * @author Udara Dikwatta <udaradikwatta@gmail.com>
 */


require_once 'index.php';


use App\Controllers\GetUserPhotoController;

(new GetUserPhotoController())->__invoke();