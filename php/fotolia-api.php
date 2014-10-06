<?php
/**
 * Example application using php5 and Zend Framework of using Fotolia API
 *
 * LICENSE
 *
 * This source file is subject to the GNU GPL v2 license
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 *
 * @category Fotolia
 * @package Models
 * @copyright Copyright (c) 2011 Fotolia LLC. (http://www.fotolia.com)
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt     GNU GPL v2
 */

/**
 * Interface to the Fotolia Rest API
 */
class Fotolia_Api
{
    /**
     * Fotolia REST uri
     */
    const FOTOLIA_REST_URI = 'https://api.fotolia.com/Rest';

    /**
     * Fotolia REST API version
     */
    const FOTOLIA_REST_VERSION = '1';

    /**
     * Refresh authentication token every 20 minutes
     */
    const TOKEN_TIMEOUT = 1200;

    /**
     * Time outs settings
     */
    const API_CONNECT_TIMEOUT = 30;
    const API_PROCESS_TIMEOUT = 120;

    /**
     * Language constants
     */
    const LANGUAGE_ID_FR_FR = 1;
    const LANGUAGE_ID_EN_US = 2;
    const LANGUAGE_ID_EN_GB = 3;
    const LANGUAGE_ID_DE_DE = 4;
    const LANGUAGE_ID_ES_ES = 5;
    const LANGUAGE_ID_IT_IT = 6;
    const LANGUAGE_ID_PT_PT = 7;
    const LANGUAGE_ID_PT_BR = 8;
    const LANGUAGE_ID_JA_JP = 9;
    const LANGUAGE_ID_PL_PL = 11;
    const LANGUAGE_ID_RU_RU = 12;
    const LANGUAGE_ID_ZH_CN = 13;
    const LANGUAGE_ID_TR_TR = 14;
    const LANGUAGE_ID_KO_KR = 15;
    const LANGUAGE_ID_NL_NL = 22;
    const LANGUAGE_ID_SV_SE = 23;

    /**
     * API key
     *
     * @var $_key string
     */
    private $_api_key;

    /**
     * Current session id
     *
     * @var $_session_id string
     */
    private $_session_id;

    /**
     * Current session id fetched timestamp
     *
     * @var $_session_id_timestamp int
     */
    private $_session_id_timestamp;

    /**
     * Constructor
     *
     * @param  string $api_key
     */
    public function __construct($api_key)
    {
        $this->_api_key = $api_key;
        $this->_session_id = NULL;
        $this->_session_id_timestamp = NULL;
    }

    /**
     * Returns current api key
     *
     * return string
     */
    public function getApiKey()
    {
        return $this->_api_key;
    }

    /**
     * This method makes possible to search media in fotolia image bank.
     * Full search capabilities are available through the API
     *
     * @param  array  $search_params
     * @param  array  $result_columns if specified, a list a columns you want in the resultset
     * @return array
     */
    public function getSearchResults(array $search_params, array $result_columns = NULL)
    {
        return $this->_api('getSearchResults',
                           array(
                               'search_parameters' => $search_params,
                               'result_columns' => $result_columns
                           ));
    }

    /**
     * This method returns childs of a parent category in fotolia representative category system.
     * This method could be used to display a part of the category system or the all tree.
     * Fotolia categories system counts three levels.
     *
     * @param  int    $language_id
     * @param  int    $id
     * @param  int    $category_type_id
     * @return array
     */
    public function getCategories1($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $id = 0)
    {
        return $this->_api('getCategories1',
                             array(
                                 'language_id' => $language_id,
                                 'id' => $id,
                             ));
    }

    /**
     * This method returns childs of a parent category in fotolia conceptual category system.
     * This method could be used to display a part of the category system or the all tree.
     * Fotolia categories system counts three levels.
     *
     * @param  int    $language_id
     * @param  int    $id
     * @return array
     */
    public function getCategories2($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $id = 0)
    {
        return $this->_api('getCategories2',
                             array(
                                 'language_id' => $language_id,
                                 'id' => $id,
                             ));
    }

    /**
     * This method returns most searched tag and most used tag on fotolia website.
     * This method may help you to create a tags cloud.
     *
     * @param  int    $language_id
     * @param  string $type
     * @return array
     */
    public function getTags($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $type = 'Used')
    {
        return $this->_api('getTags',
                            array(
                                'language_id' => $language_id,
                                'type' => $type
                            ));
    }

    /**
     * This method returns public galleries for a defined language
     *
     * @param  int    $language_id
     * @return array
     */
    public function getGalleries($language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
    {
        return $this->_api('getGalleries',
                             array(
                                 'language_id' => $language_id
                             ));
    }

    /**
     * This method returns public seasonal galleries for a defined language
     *
     * @param  int    $language_id
     * @return array
     */
    public function getSeasonalGalleries($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $thumbnail_size = 110, $theme_id = null)
    {
        return $this->_api('getSeasonalGalleries',
                              array(
                                  'language_id' => $language_id,
                                  'thumbnail_size' => $thumbnail_size,
                                  'theme_id' => $theme_id
                              ));
    }

    /**
     * This method returns Fotolia list of countries.
     *
     * @param  int    $language_id
     * @return array
     */
    public function getCountries($language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
    {
        return $this->_api('getCountries',
                             array(
                                 'language_id' => $language_id,
                             ));
    }

    /**
     * This method returns fotolia data
     *
     * @return array
     */
    public function getData()
    {
        return $this->_api('getData', array());
    }

    /**
     * This method is a test method which returns success if connexion is valid
     *
     * @return array
     */
    public function test()
    {
        return $this->_api('test', array());
    }

    /**
     * This method return all information about a media
     *
     * @param  int    $id
     * @param  int    $thumbnail_size
     * @param  int    $language_id
     * @return array
     */
    public function getMediaData($id, $thumbnail_size = 110, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
    {
        return $this->_api('getMediaData',
                             array(
                                 'id' => $id,
                                 'thumbnail_size' => $thumbnail_size,
                                 'language_id' => $language_id,
                             ));
    }

    /**
     * This method return all information about a series of media
     *
     * @param  array  $ids
     * @param  int    $thumbnail_size
     * @param  int    $language_id
     * @return array
     */
    public function getBulkMediaData(array $ids, $thumbnail_size = 110, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
    {
        return $this->_api('getBulkMediaData',
                             array(
                                 'ids' => $ids,
                                 'thumbnail_size' => $thumbnail_size,
                                 'language_id' => $language_id,
                             ));
    }

    /**
     * This method return private galleries for logged user
     *
     * @param  int    $id
     * @param  int    $language_id
     * @param  int    $thumbnail_size
     * @return array
     */
    public function getMediaGalleries($id, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $thumbnail_size = 110)
    {
        return $this->_api('getMediaGalleries',
                             array(
                                 'id' => $id,
                                 'language_id' => $language_id,
                                 'thumbnail_size' => $thumbnail_size,
                             ));
    }

    /**
     * This method allows to purchase a media and returns url to the purchased file
     *
     * @param  int    $id
     * @param  string $license_name
     * @param  int    $subaccount_id
     * @return array
     */
    public function getMedia($id, $license_name, $subaccount_id = NULL)
    {
        return $this->_api('getMedia',
                             array(
                                 'id' => $id,
                                 'license_name' => $license_name,
                                 'subaccount_id' => $subaccount_id,
                             ));
    }

    /**
     * Download a media and write it to a file if necessary
     *
     * @param  string $download_url URL as returned by getMedia()
     * @param  string $output_file if null the downloaded file will be echoed on standard output
     */
    public function downloadMedia($download_url, $output_file = NULL)
    {
        return $this->_download($download_url, $output_file);
    }

    /**
     * Download a media comp and write it to a file if necessary
     *
     * @param  string $download_url URL as returned by getMediaComp()
     * @param  string $output_file if null the downloaded file will be echoed on standard output
     */
    public function downloadMediaComp($download_url, $output_file = NULL)
    {
        return $this->_download($download_url, $output_file, false);
    }

    /**
     * Download a content and write it to a file if necessary
     *
     * @param  string $download_url URL
     * @param  string $output_file if null the downloaded file will be echoed on standard output
     * @param  bool $http_auth set curl password if needed
     */
    private function _download($download_url, $output_file = NULL, $http_auth_required = true)
    {
        $ch = $this->_getCurlHandler($download_url);

        if ($output_file === NULL) {
            if ($this->_isShellMode()) {
                $output_file = 'php://stdout';
            } else {
                $output_file = 'php://output';
            }
        }

        $output_fd = fopen($output_file, 'w');
        if ($output_fd === FALSE) {
            throw new Fotolia_Api_Exception('Cannot open ' . $output_file . ' for writing');
        }

        curl_setopt($ch, CURLOPT_FILE, $output_fd);
        curl_setopt($ch, CURLOPT_USERPWD, $this->_getHttpAuth(TRUE, $http_auth_required));

        $response = curl_exec($ch);

        fclose($output_fd);

        if (!$response) {
            throw new Fotolia_Api_Exception('Failed to reach URL "' . $uri . '": ' . curl_error($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if (empty($content_type)) {
            throw new Fotolia_Api_Exception('Invalid response, no content type returned');
        }

        if (strstr($content_type, ';') !== FALSE) {
            list($content_type, $charset) = explode(';', $content_type);
        }

        list($major_mime, $minor_mime) = explode('/', $content_type);

        if ($major_mime == 'application') {
            if ($minor_mime == 'json') {
                $res = json_decode($response, TRUE);
                if (isset($res['error'])) {
                    throw new Fotolia_Api_Exception($res['error'], !empty($res['code']) ? $res['code'] : 0);
                }
            }

            if ($http_code != 200) {
                throw new Fotolia_Api_Exception('Unknown API error');
            }
        } elseif ($http_code != 200) {
            throw new Fotolia_Api_Exception('Invalid response HTTP code: ' . $http_code);
        }
    }

    /**
     * This method returns comp images. Comp images can ONLY be used to evaluate the image
     * as to suitability for a project, obtain client or internal company approvals,
     * or experiment with layout alternatives.
     *
     * @param  int    $id
     * @return array
     */
    public function getMediaComp($id)
    {
        return $this->_api('getMediaComp',
                             array(
                                 'id' => $id,
                             ));
    }

    /**
     * Authenticate an user
     *
     * @param  string $login User login
     * @param  string $pass User password
     */
    public function loginUser($login, $pass)
    {
        $res = $this->_api('loginUser',
                             array(
                                 'login' => $login,
                                 'pass' => $pass,
                             ));

        $this->_session_id = $res['session_token'];
        $this->_session_id_timestamp = time();
    }

    /**
     * Log out an user
     */
    public function logoutUser()
    {
        $this->_session_id = NULL;
    }

    /**
     * Create a new Fotolia Member
     *
     * @param  array $properties
     * @return int
     */
    public function createUser(array $properties)
    {
        $required_properties = array(
            'login',
            'password',
            'email',
            'language_id'
        );

        foreach ($required_properties as $required_property) {
            if (empty($properties[$required_property])) {
                throw new Fotolia_Api_Exception('Missing required property: ' . $required_property);
            }
        }

        return $this->_api('createUser', array('properties' => $properties));
    }

    /**
     * This method returns data for logged user.
     *
     * @return array
     */
    public function getUserData()
    {
        return $this->_api('getUserData',
                             array());
    }

    /**
     * This method returns sales data for logged user.
     *
     * @param  string $sales_type
     * @param  int    $offset
     * @param  int    $limit
     * @param  int    $id
     * @param  string $sales_day
     * @return array
     */
    public function getSalesData($sales_type = 'all', $offset = 0, $limit = 50, $id = NULL, $sales_day = NULL)
    {
        $valid_sales_types = array(
            'all',
            'subscription',
            'standard',
            'extended',
        );
        if (!in_array($sales_type, $valid_sales_types)) {
            throw new Fotolia_Api_Exception('Undefined sales type: ' . $sales_type);
        }

        return $this->_api('getSalesData',
                           array(
                               'sales_type' => $sales_type,
                               'offset' => $offset,
                               'limit' => $limit,
                               'id' => $id,
                               'sales_day' => $sales_day,
                           ));
    }

    /**
     * This method allows you to get sales/views/income statistics from your account.
     *
     * @param  string $type
     * @param  string $time_range
     * @param  string $easy_date_period
     * @param  string $start_date
     * @param  string $end_date
     * @return array
     */
    public function getUserAdvancedStats($type,
                                         $time_range,
                                         $easy_date_period = NULL,
                                         $start_date = NULL,
                                         $end_date = NULL)
    {
        return $this->_api('getUserAdvancedStats',
                             array(
                                 'type' => $type,
                                 'time_range' => $time_range,
                                 'easy_date_periods' => $easy_date_period,
                                 'start_date' => $start_date,
                                 'end_date' => $end_date,
                             ));
    }

    /**
     * This methods returns statistics for logged user
     *
     * @return array
     */
    public function getUserStats()
    {
        return $this->_api('getUserStats',
                             array());
    }

    /**
     * Delete a user's gallery
     *
     * @param  string $id
     */
    public function deleteUserGallery($id)
    {
        $this->_api('deleteUserGallery',
                      array(
                          'id' => $id,
                      ));
    }

    /**
     * This method allows you to create a new gallery in your account.
     *
     * @param  string $name
     * @return array
     */
    public function createUserGallery($name)
    {
        return $this->_api('createUserGallery',
                             array(
                                 'name' => $name,
                             ));
    }

    /**
     * This method allows you to add a content to your default lightbox or any of your existing galleries
     *
     * @param  int    $content_id
     * @param  string $id
     * @return array
     */
    public function addToUserGallery($content_id, $id = '')
    {
        return $this->_api('addToUserGallery',
                             array(
                                 'content_id' => $content_id,
                                 'id' => $id,
                             ));
    }

    /**
     * This method allows you to remove a content from your default lightbox or any of your existing galleries
     *
     * @param  int    $content_id
     * @param  string $id
     * @return array
     */
    public function removeFromUserGallery($content_id, $id = '')
    {
        return $this->_api('removeFromUserGallery',
                             array(
                                 'content_id' => $content_id,
                                 'id' => $id,
                             ));
    }

    /**
     * This method allows to search media in logged user galleries or lightbox.
     *
     * @param  int    $page
     * @param  int    $per_page
     * @param  int    $thumbnail_size
     * @param  string $id
     * @return array
     */
    public function getUserGalleryMedias($page = 0,
                                         $nb_per_page = 32,
                                         $thumbnail_size = 110,
                                         $id = '')
    {
        return $this->_api('getUserGalleryMedias',
                             array(
                                 'page' => $page,
                                 'nb_per_page' => $nb_per_page,
                                 'thumbnail_size' => $thumbnail_size,
                                 'id' => $id,
                             ));
    }

    /**
     * This method returns private galleries for logged user.
     *
     * @return array
     */
    public function getUserGalleries()
    {
        return $this->_api('getUserGalleries',
                             array());
    }

    /**
     * This method allows move up media in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveUpMediaInUserGallery($content_id, $id = '')
    {
        $this->_api('moveUpMediaInUserGallery',
                    array(
                        'content_id' => $content_id,
                        'id' => $id,
                    ));
    }

    /**
     * This method allows move down media in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveDownMediaInUserGallery($content_id, $id = '')
    {
        $this->_api('moveDownMediaInUserGallery',
                    array(
                        'content_id' => $content_id,
                        'id' => $id,
                    ));
    }

    /**
     * This method allows move a media to top position in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveMediaToTopInUserGallery($content_id, $id = '')
    {
        $this->_api('moveMediaToTopInUserGallery',
                    array(
                        'content_id' => $content_id,
                        'id' => $id,
                    ));
    }

    /**
     * Create a new subaccount for the given api key
     *
     * @param  array $subaccount_data
     * @return int
     */
    public function subaccountCreate($subaccount_data)
    {
        return $this->_api('user/subaccount/create',
                             array(
                                 'subaccount_data' => $subaccount_data,
                             ));
    }

    /**
     * Edit a subaccount of the given api key
     *
     * @param  int   $subaccount_id
     * @param  array $subaccount_data
     */
    public function subaccountEdit($subaccount_id, $subaccount_data)
    {
        $this->_api('user/subaccount/edit',
                      array(
                          'subaccount_id' => $subaccount_id,
                          'subaccount_data' => $subaccount_data,
                      ));
    }

    /**
     * Delete a subaccount of the given api key
     *
     * @param  int   $subaccount_id
     */
    public function subaccountDelete($subaccount_id)
    {
        $this->_api('user/subaccount/delete',
                      array(
                          'subaccount_id' => $subaccount_id,
                      ));
    }

    /**
     * Returns the ids of all subaccounts of the api key
     *
     * @return array
     */
    public function subaccountGetIds()
    {
        return $this->_api('user/subaccount/getIds',
                             array());
    }

    /**
     * Returns details of a given subaccount
     *
     * @param  int   $subaccount_id
     * @return array
     */
    public function subaccountGet($subaccount_id)
    {
        return $this->_api('user/subaccount/get',
                      array(
                          'subaccount_id' => $subaccount_id,
                      ));
    }

    /**
     * Returns the purchased contents of a given subaccount
     *
     * @param  int    $subaccount_id
     * @param  int    $page current page number
     * @param  int    $nb_per_page number of downloads per page
     * @return array
     */
    public function subaccountgetPurchasedContents($subaccount_id, $page = 1, $nb_per_page = 10)
    {
        return $this->_api('user/subaccount/getPurchasedContents',
                             array(
                                 'subaccount_id' => $subaccount_id,
                                 'page' => $page,
                                 'nb_per_page' => $nb_per_page,
                             ));
    }

    /**
     * Retrieve the content of the shopping cart
     * @return array
     */
    public function shoppingcartGetList()
    {
        return $this->_api('shoppingcart/getList',
                             array());
    }

    /**
     * Clear the content of the shopping cart
     * @return array
     */
    public function shoppingcartClear()
    {
        return $this->_api('shoppingcart/clear',
                             array());
    }

    /**
     * Transfer one or more files from the shopping cart to a lightbox
     *
     * @param  int|array $id
     * @return array
     */
    public function shoppingtransferToLightbox($id)
    {
        return $this->_api('shoppingcart/transferToLightbox',
                             array(
                                 'id' => $id,
                             ));
    }

    /**
     * Add a content to the shopping cart
     *
     * @param  int $id
     * @param  string $license_name
     * @return array
     */
    public function shoppingcartAdd($id, $license_name)
    {
        return $this->_api('shoppingcart/add',
                           array(
                               'id' => $id,
                               'license_name' => $license_name,
                           ));
    }

    /**
     * Update a content to the shopping cart
     *
     * @param  int $id
     * @param  string $license_name
     * @return array
     */
    public function shoppingcartUpdate($id, $license_name = NULL)
    {
        return $this->_api('shoppingcart/update',
                           array(
                               'id' => $id,
                               'license_name' => $license_name,
                           ));
    }

    /**
     * Delete a content from the shopping cart
     *
     * @param  int $id
     * @return array
     */
    public function shoppingcartRemove($id)
    {
        return $this->_api('shoppingcart/remove',
                           array(
                               'id' => $id,
                           ));
    }

    /**
     * Magic method used to call fotolia rest functions
     *
     * @param  string $method
     * @param  array  $args
     * @param  boolean $auto_refresh_token if set to TRUE, session token will be refreshed if needed
     * @return array
     * @throws Fotolia_Api_Exception
     */
    protected function _api($method, $args = array(), $auto_refresh_token = TRUE)
    {
        static $cnt = 1;

        if (!$this->_isPostMethod($method)) {
            $query = $args;
            $post_data = NULL;
        } else {
            $query = NULL;
            $post_data = $args;
        }

        $uri = $this->_getFullURI($method, $query);

        $ch = $this->_getCurlHandler($uri, $post_data, $auto_refresh_token);

        $time_start = microtime(TRUE);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === FALSE) {
            throw new Fotolia_Api_Exception('Failed to reach URL "' . $uri . '": ' . curl_error($ch));
        }

        curl_close($ch);

        $res = json_decode($response, TRUE);

        if (isset($res['error']) || $http_code != 200) {
            $error_code = 0;

            if (isset($res['error'])) {
                $error_msg = $res['error'];

                if (!empty($res['code'])) {
                    $error_code = (int) $res['code'];
                }
            } else {
                $error_msg = 'Invalid response HTTP code: ' . $http_code;
            }

            throw new Fotolia_Api_Exception($error_msg, $error_code);
        }

        $time_end = microtime(TRUE);

        if (!headers_sent()) {
            header('X-Fotolia-API-Call-Method-' . $cnt . ': ' . $method);
            header('X-Fotolia-API-Call-Time-' . $cnt . ': ' . ($time_end - $time_start));
        }
        $cnt++;

        return $res;
    }

    /**
     * Returns xml-rpc client
     *
     * @return Zend_XmlRpc_Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Returns namespace associated to given method name
     *
     * @param  string $method
     * @return string
     * @throws Fotolia_Api_Exception
     */
    protected function _getNamespace($method)
    {
        switch ($method) {
            case 'getSearchResults':
            case 'getCategories1':
            case 'getCategories2':
            case 'getTags':
            case 'getGalleries':
            case 'getSeasonalGalleries':
            case 'getCountries':
                return 'search';

            case 'getMediaData':
            case 'getBulkMediaData':
            case 'getMediaGalleries':
            case 'getMedia':
            case 'getMediaComp':
                return 'media';

            case 'loginUser':
            case 'createUser':
            case 'refreshToken':
            case 'getUserData':
            case 'getSalesData':
            case 'getUserGalleries':
            case 'getUserGalleryMedias':
            case 'deleteUserGallery':
            case 'createUserGallery':
            case 'addToUserGallery':
            case 'removeFromUserGallery':
            case 'moveUpMediaInUserGallery':
            case 'moveDownMediaInUserGallery':
            case 'moveMediaToTopInUserGallery':
            case 'getUserAdvancedStats':
            case 'getUserStats':
                return 'user';

            case 'getData':
            case 'test':
                return 'main';

            case 'user/subaccount/create':
            case 'user/subaccount/edit':
            case 'user/subaccount/delete':
            case 'user/subaccount/getIds':
            case 'user/subaccount/get':
            case 'user/subaccount/getPurchasedContents':
            case 'shoppingcart/getList':
            case 'shoppingcart/add':
            case 'shoppingcart/update':
            case 'shoppingcart/remove':
            case 'shoppingcart/clear':
                return '';

            default:
                throw new Fotolia_Api_Exception('Unknown or unsuported method: ' . $method);
        }
    }

    /**
     * Returns current session id
     *
     * @param  boolean $auto_refresh_token if set to TRUE, session token will be refreshed if needed
     * @return string
     * @throws Fotolia_Api_Exception
     */
    protected function _getSessionId($auto_refresh_token = TRUE)
    {
        if (
            $this->_session_id
            && time() > $this->_session_id_timestamp + Fotolia_Api::TOKEN_TIMEOUT
            && $auto_refresh_token
        ) {
            $res = $this->_api('refreshToken', array(), FALSE);
            $this->_session_id = $res['session_token'];
            $this->_session_id_timestamp = time();
        }

        return $this->_session_id;
    }

    /**
     * Generate the full URI to use for API calls
     *
     * @param  string $method
     * @param  array  $query
     * @return string
     */
    private function _getFullURI($method, array $query = NULL)
    {
        $namespace = $this->_getNamespace($method);
        if (!empty($namespace)) {
            $namespace .= '/';
        }

        $uri = Fotolia_Api::FOTOLIA_REST_URI . '/'
            . Fotolia_Api::FOTOLIA_REST_VERSION . '/' . $namespace . $method;

        if ($query !== NULL) {
            $uri .= '?' . http_build_query($query);
        }

        return $uri;
    }

    /**
     * Returns a valid cUrl handler
     *
     * @param  string $uri
     * @param  array $post_data
     * @param  boolean $auto_refresh_token if set to TRUE, session token will be refreshed if needed
     */
    protected function _getCurlHandler($uri, array $post_data = NULL, $auto_refresh_token = TRUE)
    {
        $ch = curl_init($uri);

        curl_setopt($ch, CURLOPT_USERPWD, $this->_getHttpAuth($auto_refresh_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Fotolia_Api::API_CONNECT_TIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, Fotolia_Api::API_PROCESS_TIMEOUT);

        if ($post_data !== NULL) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        }

        return $ch;
    }

    /**
     * Returns the HTTP credentials to use
     *
     * @param  boolean $auto_refresh_token if set to TRUE, session token will be refreshed if needed
     * @param  boolean $force_non_empty_session_id
     * @return string
     */
    private function _getHttpAuth($auto_refresh_token = TRUE, $force_non_empty_session_id = FALSE)
    {
        $auth = $this->_api_key . ':';
        $session_id = $this->_getSessionId($auto_refresh_token);
        if (!empty($session_id)) {
            $auth .= $session_id;
        } elseif ($force_non_empty_session_id) {
            throw new Fotolia_Api_Exception('Needs a valid session ID');
        }

        return $auth;
    }

    /**
     * Returns TRUE if the method requires
     *
     * @param  string $method
     * @return boolean
     */
    private function _isPostMethod($method)
    {
        switch ($method) {
            case 'loginUser':
            case 'createUser':
            case 'shoppingcart/add':
            case 'shoppingcart/update':
            case 'shoppingcart/remove':
            case 'shoppingcart/transferToLightbox':
            case 'shoppingcart/clear':
            case 'refreshToken':
            case 'deleteUserGallery':
            case 'createUserGallery':
            case 'renameUserGallery':
            case 'addToUserGallery':
            case 'removeFromUserGallery':
            case 'moveUpMediaInUserGallery':
            case 'moveDownMediaInUserGallery':
            case 'moveMediaToTopInUserGallery':
            case 'updateProfile':
            case 'user/subaccount/create':
            case 'user/subaccount/edit':
            case 'user/subaccount/delete':
            case 'user/subaccount/createSubscription':
            case 'user/subaccount/deleteSubscription':
                $is_post_method = TRUE;
                break;

            default:
                $is_post_method = FALSE;
        }

        return $is_post_method;
    }

    /*
     * Define if the api is called in CLI mode
     */
    private function _isShellMode()
    {
        return !empty($_SERVER['SHELL']);
    }
}

/**
 * API Exception
 */
class Fotolia_Api_Exception extends Exception {}
