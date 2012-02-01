#!/usr/bin/env python

import fotolia_api

api = fotolia_api.FotoliaApi('your_api_key')

# searching for files
results = api.get_search_results({'words': 'car', 'language_id': fotolia_api.LANGUAGE_ID_EN_US, 'limit': 1})
print "Found %d results" % results['nb_results']

for key, value in results.items():
    try:
        int(key)
        print "matching media ID: %d" % value['id']
    except ValueError:
        # iterating only over numeric keys and silently skip other keys
        pass

# loggin in and retrieving user data
api.login_user('your_login', 'your_password')
print api.get_user_data()

# purchasing and downloading a file
dl_data = api.get_media(35957426, 'XS')
api.download_media(dl_data['url'], '/tmp/' + str(dl_data['name']))
