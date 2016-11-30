import pycurl
import json
import urllib
import time
import os

from io import BytesIO

import fotolia_api

class Rest:
    """
    Fotolia REST API implementation
    """

    # api key
    _api_key = None

    # session ID if any
    _session_id = None

    # session ID timestamp if any
    _session_id_timestamp = None

    def __init__(self, api_key):
        """
        Constructor
        """

        self._api_key = api_key
        self._session_id = None
        self._session_id_timestamp = None

    def get_api_key(self):
        """
        Returns the current API key
        """

        return self._api_key

    def get_search_results(self, search_params, result_columns = []):
        """
        This method makes possible to search media in fotolia image bank.
        Full search capabilities are available through the API
        """

        params = {
            'search_parameters': search_params,
            'result_columns': result_columns
            }

        return self._api('getSearchResults', params)

    def get_categories1(self, language_id = fotolia_api.LANGUAGE_ID_EN_US, id = 0):
        """
        This method returns childs of a parent category in fotolia representative category system.
        This method could be used to display a part of the category system or the all tree.
        Fotolia categories system counts three levels.
        """

        params = {
            'language_id': language_id,
            'id': id
            }

        return self._api('getCategories1', params)

    def get_categories2(self, language_id = fotolia_api.LANGUAGE_ID_EN_US, id = 0):
        """
        This method returns childs of a parent category in fotolia conceptual category system.
        This method could be used to display a part of the category system or the all tree.
        Fotolia categories system counts three levels.
        """

        params = {
            'language_id': language_id,
            'id': id
            }

        return self._api('getCategories2', params)

    def get_tags(self, language_id = fotolia_api.LANGUAGE_ID_EN_US, type = 'Used'):
        """
        This method returns most searched tag and most used tag on fotolia website.
        This method may help you to create a tags cloud.
        """

        params = {
            'language_id': language_id,
            'type': type
            }

        return self._api('getTags', params)

    def get_galleries(self, language_id = fotolia_api.LANGUAGE_ID_EN_US):
        """
        This method returns public galleries for a defined language
        """

        params = {
            'language_id': language_id
            }

        return self._api('getGalleries', params)

    def get_seasonal_galleries(self, language_id = fotolia_api.LANGUAGE_ID_EN_US, thumbnail_size = fotolia_api.THUMB_SIZE_SMALL, theme_id = None):
        """
        This method returns public galleries for a defined language
        """

        params = {
            'language_id': language_id,
            'thumbnail_size': thumbnail_size
            }

        if theme_id != None:
            params['theme_id'] = theme_id

        return self._api('getSeasonalGalleries', params)

    def get_countries(self, language_id = fotolia_api.LANGUAGE_ID_EN_US):
        """
        This method returns Fotolia list of countries
        """

        params = {
            'language_id': language_id
            }

        return self._api('getCountries', params)

    def get_data(self):
        """
        This method returns fotolia general data
        """

        return self._api('getData')

    def test(self):
        """
        This method is a test method which returns success if connexion is valid
        """

        return self._api('test')

    def get_media_data(self, id, thumbnail_size = fotolia_api.THUMB_SIZE_SMALL, language_id = fotolia_api.LANGUAGE_ID_EN_US):
        """
        This method return all information about a media
        """

        params = {
            'id': id,
            'thumbnail_size': thumbnail_size,
            'language_id': language_id
            }

        return self._api('getMediaData', params)

    def get_bulk_media_data(self, ids, thumbnail_size = fotolia_api.THUMB_SIZE_SMALL, language_id = fotolia_api.LANGUAGE_ID_EN_US):
        """
        This method return all information about a series of media
        """

        params = {
            'ids': ids,
            'thumbnail_size': thumbnail_size,
            'language_id': language_id
            }

        return self._api('getBulkMediaData', params)

    def get_media_galleries(self, id, thumbnail_size = fotolia_api.THUMB_SIZE_SMALL, language_id = fotolia_api.LANGUAGE_ID_EN_US):
        """
        This method return private galleries for logged user
        """

        params = {
            'id': id,
            'language_id': language_id,
            'thumbnail_size': thumbnail_size
            }

        return self._api('getMediaGalleries', params)

    def get_media(self, id, license_name, subaccount_id = None):
        """
        This method allows to purchase a media
        """

        params = {
            'id': id,
            'license_name': license_name,
            'subaccount_id': subaccount_id
            }

        return self._api('getMedia', params)

    def download_media(self, download_url, output_file = None):
        """
        Download a media and write it to a file if necessary.
        Otherwise returns a stream to it
        """

        # convert URL from unicode to ascii if needed
        if type(download_url).__name__ == 'unicode':
            download_url = str(download_url)

        curl = self._get_curl(download_url)

        if output_file == None:
            buf = StringIO.StringIO()
        else:
            buf = open(output_file, 'w')

        curl.setopt(pycurl.WRITEFUNCTION, buf.write)
        curl.perform()
        http_code = curl.getinfo(pycurl.HTTP_CODE)
        content_type = curl.getinfo(pycurl.CONTENT_TYPE)

        if not content_type:
            raise fotolia_api.ApiError('Invalid response, no content type returned')


        if ';' in content_type:
            splitted_content_type = content_type.split(';')
            content_type = splitted_content_type[0]

        mime_type = content_type.split('/')
        if mime_type[0] == 'application':
            if mime_type[1] == 'json':
                if type(buf).__name__ == 'file':
                    res = json.loads(buf.read())
                    buf.close()
                    os.unlink(output_file)
                else:
                    res = json.loads(buf.getvalue())

                if 'error' in res:
                    error_code = 0
                    if 'code' in res:
                        error_code = res['code']

                    raise fotolia_api.ApiError(res['error'], error_code)

            raise fotolia_api.ApiError('Unknown API error')
        elif http_code != 200:
            raise fotolia_api.ApiError('Invalid response HTTP code: ' + str(http_code))

        if type(buf).__name__ == 'file':
            buf.close()
        else:
            return buf

    def get_media_comp(self, id):
        """
        This method returns comp images. Comp images can ONLY be used to evaluate the image
        as to suitability for a project, obtain client or internal company approvals,
        or experiment with layout alternatives.
        """

        params = {
            'id': id
            }

        return self._api('getMediaComp', params)

    def login_user(self, login, password):
        """
        Authenticate a user
        """

        params = {
            'login': login,
            'pass': password
            }

        res = self._api('loginUser', params)
        self._session_id = str(res['session_token'])
        self._session_id_timestamp = time.time()

    def logout_user(self):
        """
        Log out a user
        """

        self._session_id = None
        self._session_id_timestamp = None

    def create_user(self, properties):
        """
        Create a user
        """

        required_properties = [
            'login',
            'password',
            'email',
            'language_id'
            ]

        for required_property in required_properties:
            if required_property not in properties.keys():
                fotolia_api.ApiError('Missing required property: ' + required_property)

        return self._api('createUser', properties)

    def get_user_data(self):
        """
        This method returns data for logged user.
        """

        return self._api('getUserData')

    def get_sales_data(self, sales_type = 'all', offset = 0, limit = 50, id = None, sales_day = None):
        """
        This method returns sales data for logged user.
        """

        valid_sales_types = [
            'all',
            'subscription',
            'standard',
            'extended'
        ]

        if not sales_type in valid_sales_types:
            fotolia_api.ApiError('Undefined sales type: ' + sales_type)

        params = {
            'sales_type': sales_type,
            'offset': offset,
            'limit': limit,
            'sales_day': sales_day,
            'id': id
            }

        return self._api('getSalesData', params)

    def get_user_advanced_stats(self, type, time_range, easy_date_period = None, start_date = None, end_data = None):
        """
        This method allows you to get sales/views/income statistics from your account.
        """

        params = {
            'type': type,
            'time_range': time_range,
            'easy_date_periods': easy_date_period,
            'start_date': start_date,
            'end_date': end_date
            }

        return self._api('getUserAdvancedStats', params)

    def get_user_stats(self):
        """
        This methods returns statistics for logged user
        """

        return self._api('getUserStats')

    def delete_user_gallery(self, id):
        """
        Delete a user's gallery
        """

        params = {
            'id': id
            }

        return self._api('deleteUserGallery', params)

    def create_user_gallery(self, name):
        """
        This method allows you to create a new gallery in your account.
        """

        params = {
            'name': name
            }

        return self._api('createUserGallery', params)

    def add_to_user_gallery(self, content_id, id = ''):
        """
        This method allows you to add a content to your default lightbox or any of your existing galleries
        """

        params = {
            'content_id': content_id,
            'id': id
            }

        return self._api('addToUserGallery', params)

    def remove_from_user_gallery(self, content_id, id = ''):
        """
        This method allows you to remove a content from your default lightbox or any of your existing galleries
        """

        params = {
            'content_id': content_id,
            'id': id
            }

        return self._api('removeFromUserGallery', params)

    def get_user_gallery_media(self, page = 0, per_page = 32, thumbnail_size = fotolia_api.THUMB_SIZE_SMALL, id = ''):
        """
        This method allows to search media in logged user galleries or lightbox.
        """

        params = {
            'page': page,
            'per_page': per_page,
            'thumbnail_size': thumbnail_size,
            'id': id
            }

        return self._api('getUserGalleryMedias', params)

    def get_user_galleries(self):
        """
        This method returns private galleries for logged user.
        """

        return self._api('getUserGalleries')

    def move_up_media_in_user_gallery(self, content_id, id = ''):
        """
        This method allows move up media in logged user galleries or lightbox.
        """

        params = {
            'content_id': content_id,
            'id': id
            }

        return self._api('moveUpMediaInUserGallery', params)

    def move_down_media_in_user_gallery(self, content_id, id = ''):
        """
        This method allows move down media in logged user galleries or lightbox.
        """

        params = {
            'content_id': content_id,
            'id': id
            }

        return self._api('moveDownMediaInUserGallery', params)

    def move_media_to_top_in_user_gallery(self, content_id, id = ''):
        """
        This method allows move a media to top position in logged user galleries or lightbox.
        """

        params = {
            'content_id': content_id,
            'id': id
            }

        return self._api('moveMediaToTopInUserGallery', params)

    def subaccount_create(self, subaccount_data):
        """
        Create a new subaccount for the given api key
        """

        params = {
            'subaccount_data': subaccount_data
            }

        return self._api('user/subaccount/create', params)

    def subaccount_edit(self, subaccount_id, subaccount_data):
        """
        Edit a new subaccount for the given api key
        """

        params = {
            'subaccount_id': subaccount_id,
            'subaccount_data': subaccount_data
            }

        return self._api('user/subaccount/edit', params)

    def subaccount_delete(self, subaccount_id):
        """
        Delete a subaccount for the given api key
        """

        params = {
            'subaccount_id': subaccount_id
            }

        return self._api('user/subaccount/delete', params)

    def subaccount_get_ids(self):
        """
        Returns the ids of all subaccounts of the api key
        """

        return self._api('user/subaccount/getIds')

    def subaccount_get(self, subaccount_id):
        """
        Returns details of a given subaccount
        """

        params = {
            'subaccount_id': subaccount_id
            }

        return self._api('user/subaccount/get', params)

    def subaccount_get_purchased_contents(self, subaccount_id, page = 1, nb_per_page = 10):
        """
        Returns the purchased contents of a given subaccount
        """

        params = {
            'subaccount_id': subaccount_id,
            'page': page,
            'nb_per_page': nb_per_page
            }

        return self._api('user/subaccount/getPurchasedContents', params)

    def shoppingcart_get_list(self):
        """
        Retrieve the content of the shopping cart
        """

        return self._api('shoppingcart/getList')

    def shoppingcart_clear(self):
        """
        Clear the content of the shopping cart
        """

        return self._api('shoppingcart/clear')

    def shoppingcart_transfer_to_lightbox(self, id):
        """
        Transfer one or more files from the shopping cart to a lightbox
        """

        params = {
            'id': id
            }

        return self._api('shoppingcart/transferToLightbox', params)

    def shoppingcart_add(self, id, license_name):
        """
        Add a content to the shopping cart
        """

        params = {
            'id': id,
            'license_name': license_name
            }

        return self._api('shoppingcart/add', params)

    def shoppingcart_update(self, id, license_name):
        """
        Update a content to the shopping cart
        """

        params = {
            'id': id,
            'license_name': license_name
            }

        return self._api('shoppingcart/update', params)

    def shoppingcart_remove(self, id):
        """
        Remove a content from the shopping cart
        """

        params = {
            'id': id
            }

        return self._api('shoppingcart/remove', params)


    ##
    ## Private methods
    ##

    def _api(self, method, args = {}, auto_refresh_token = True):
        """
        Generic handler for Fotolia REST API
        """

        if self._is_post_method(method):
            query = None
            post_data = args
        else:
            query = args
            post_data = None

        uri = self._get_full_uri(method, query)
        curl = self._get_curl(uri, post_data, auto_refresh_token)

        buf = BytesIO()
        curl.setopt(pycurl.WRITEFUNCTION, buf.write)
        curl.perform()
        http_code = curl.getinfo(pycurl.HTTP_CODE)

        res = json.loads(buf.getvalue().decode('utf-8'))

        if 'error' in res or http_code != 200:
            error_code = 0
            if 'error' in res:
                error_msg = res['error']
                if 'code' in res:
                    error_code = int(res['code'])
            else:
                error_msg = 'Invalid response HTTP code: ' + str(http_code)

            raise fotolia_api.ApiError(error_msg, error_code)

        return res

    def _get_curl(self, uri, post_data = None, auto_refresh_token = True):
        """
        Construct and return the curl handle to use to consume the API
        """

        curl = pycurl.Curl()
        curl.setopt(pycurl.URL, uri)
        curl.setopt(pycurl.USERPWD, self._get_http_auth(auto_refresh_token))
        curl.setopt(pycurl.CONNECTTIMEOUT, fotolia_api.API_CONNECT_TIMEOUT)
        curl.setopt(pycurl.TIMEOUT, fotolia_api.API_PROCESS_TIMEOUT)

        if post_data != None:
            curl.setopt(pycurl.POST, True)
            curl.setopt(pycurl.POSTFIELDS, self._recursive_urlencode(post_data))

        return curl

    def _get_http_auth(self, auto_refresh_token = True, force_non_empty_session_id = False):
        """
        Returns the HTTP credentials to use
        """

        auth = self._api_key + ':'
        session_id = self._get_session_id(auto_refresh_token)

        if session_id != None:
            auth += session_id
        elif force_non_empty_session_id:
            raise ValueError('Needs a valid session ID')

        return auth

    def _get_session_id(self, auto_refresh_token = True):
        """
        Returns current session ID
        """

        if self._session_id != None and \
                time.time() > self._session_id_timestamp + fotolia_api.TOKEN_TIMEOUT and \
                auto_refresh_token:
            res = self._api('refreshToken', None, False)
            self._session_id = str(res['session_token'])
            self._session_id_timestamp = time.time()

        return self._session_id

    def _is_post_method(self, method):
        """
        Checks whether or not a method requires a POST action
        """

        if False or \
                method == 'loginUser' or \
                method == 'createUser' or \
                method == 'shoppingcart/add' or \
                method == 'shoppingcart/update' or \
                method == 'shoppingcart/remove' or \
                method == 'shoppingcart/transferToLightbox' or \
                method == 'shoppingcart/clear' or \
                method == 'refreshToken' or \
                method == 'deleteUserGallery' or \
                method == 'createUserGallery' or \
                method == 'renameUserGallery' or \
                method == 'addToUserGallery' or \
                method == 'removeFromUserGallery' or \
                method == 'moveUpMediaInUserGallery' or \
                method == 'moveDownMediaInUserGallery' or \
                method == 'moveMediaToTopInUserGallery' or \
                method == 'updateProfile' or \
                method == 'user/subaccount/create' or \
                method == 'user/subaccount/edit' or \
                method == 'user/subaccount/delete' or \
                method == 'user/subaccount/createSubscription' or \
                method == 'user/subaccount/deleteSubscription':
            is_post_method = True
        else:
            is_post_method = False

        return is_post_method

    def _get_full_uri(self, method, query = None):
        """
        Generate the full URI to use for API calls
        """

        namespace = self._get_namespace(method)
        if namespace != None:
            namespace += '/'
        else:
            namespace = ''

        uri = fotolia_api.REST_URI + '/' + fotolia_api.REST_VERSION + '/' + namespace + method

        if query != None:
            uri += '?' + self._recursive_urlencode(query)

        return uri

    def _get_namespace(self, method):
        """
        returns the namespace to use for an API call
        """

        if False or \
                method == 'getSearchResults' or \
                method == 'getCategories1' or \
                method == 'getCategories2' or \
                method == 'getTags' or \
                method == 'getGalleries' or \
                method == 'getSeasonalGalleries' or \
                method == 'getCountries':
            return 'search'

        if False or \
                method == 'getMediaData' or \
                method == 'getBulkMediaData' or \
                method == 'getMediaGalleries' or \
                method == 'getMedia' or \
                method == 'getMediaComp':
            return 'media'

        if False or \
                method == 'loginUser' or \
                method == 'createUser' or \
                method == 'refreshToken' or \
                method == 'getUserData' or \
                method == 'getSalesData' or \
                method == 'getUserGalleries' or \
                method == 'getUserGalleryMedias' or \
                method == 'deleteUserGallery' or \
                method == 'createUserGallery' or \
                method == 'addToUserGallery' or \
                method == 'removeFromUserGallery' or \
                method == 'moveMediaToTopInUserGallery' or \
                method == 'moveUpMediaInUserGallery' or \
                method == 'moveDownMediaInUserGallery' or \
                method == 'getUserAdvancedStats' or \
                method == 'getUserStats':
            return 'user'

        if False or \
                method == 'getData' or \
                method == 'test':
            return 'main'

        return ''

    def _recursive_urlencode(self, d):
        """
        Recursively encode a multidimensional dict
        """
        def recursion(d, base=None):
            pairs = []

            for key, value in d.items():
                if hasattr(value, 'values'):
                    pairs += recursion(value, key)
                else:
                    new_pair = None
                    if base:
                        new_pair = "%s%%5B%s%%5D=%s" % (base, urllib.parse.quote(str(key)), urllib.parse.quote(str(value)))
                        pairs.append(new_pair)
                    else:
                        if type(value).__name__ == 'list':
                            for val in value:
                                new_pair = "%s=%s" % (urllib.quote(str(key + '[]')), urllib.quote(str(val)))
                                pairs.append(new_pair)
                        elif value != None:
                            new_pair = "%s=%s" % (urllib.quote(str(key)), urllib.quote(str(value)))
                            pairs.append(new_pair)
            return pairs

        return '&'.join(recursion(d))
