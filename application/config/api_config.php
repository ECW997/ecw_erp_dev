<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['api_base_url'] = 'https://devapi.ecw.lk/api';

$config['api_endpoints'] = [
    'login' => '/login',
    'get_users' => '/users',
    'get_profile' => '/profile',
    'update_profile' => '/profile/update',
    'logout' => '/logout',
    'check_dublicate_entry_v1' => '/v1/check_dublicate_entry',
    'main_job_category_v1' => '/v1/main_job_category',
    'main_job_category_status_v1' => '/v1/main_job_category_status',

    'sub_job_category_v1' => '/v1/sub_job_category',
    'sub_job_category_status_v1' => '/v1/sub_job_category_status',
    'get_sel2_mainjob_v1' => '/v1/get_sel2_mainjob',
    'get_sel2_subjob_v1' => '/v1/get_sel2_subjob',

    'job_option_group_v1' => '/v1/job_option_group',
    'job_option_group_details_list_v1' => '/v1/job_option_group_details_list',
    'job_option_group_status_v1' => '/v1/job_option_group_status',

    'job_option_v1' => '/v1/job_option',
    'job_option_details_list_v1' => '/v1/job_option_details_list',
    'get_sel2_optiongroup_v1' => '/v1/get_sel2_optiongroup',
    'job_option_status_v1' => '/v1/job_option_status',
  
    'job_option_value_v1' => '/v1/job_option_value',
    'get_sel2_job_option_v1' => '/v1/get_sel2_job_option',
    'get_sel2_job_option_value_v1' => '/v1/get_sel2_job_option_value',
    'job_option_value_details_list_v1' => '/v1/job_option_value_details_list',
    'job_option_value_status_v1' => '/v1/job_option_value_status',

    'customer_details_v1' => '/v1/customer_details',
    'job_card_v1' => '/v1/job_card',



];