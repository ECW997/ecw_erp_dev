<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['api_base_url'] = 'https://devapi.ecw.lk/api';

$config['api_endpoints'] = [
    'login' => '/login',
    'get_users' => '/users',
    'get_profile' => '/profile',
    'update_profile' => '/profile/update',
    'logout' => '/logout',
    'main_job_category_v1' => '/v1/main_job_category',
    'main_job_category_status_v1' => '/v1/main_job_category_status',
    'sub_job_category_v1' => '/v1/sub_job_category',
    'get_sel2_mainjob_v1' => '/v1/get_sel2_mainjob',
    'get_sel2_subjob_v1' => '/v1/get_sel2_subjob',
];