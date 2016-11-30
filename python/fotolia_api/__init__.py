REST_URI = "https://api.fotolia.com/Rest"
REST_VERSION = "1"

LANGUAGE_ID_FR_FR = 1
LANGUAGE_ID_EN_US = 2
LANGUAGE_ID_EN_GB = 3
LANGUAGE_ID_DE_DE = 4
LANGUAGE_ID_ES_ES = 5
LANGUAGE_ID_IT_IT = 6
LANGUAGE_ID_PT_PT = 7
LANGUAGE_ID_PT_BR = 8
LANGUAGE_ID_JA_JP = 9
LANGUAGE_ID_PL_PL = 11
LANGUAGE_ID_RU_RU = 12
LANGUAGE_ID_ZH_CN = 13
LANGUAGE_ID_TR_TR = 14
LANGUAGE_ID_KO_KR = 15

TOKEN_TIMEOUT = 1200

API_CONNECT_TIMEOUT = 30
API_PROCESS_TIMEOUT = 120

THUMB_SIZE_TINY = 30
THUMB_SIZE_SMALL = 110
THUMB_SIZE_MEDIUM = 160
THUMB_SIZE_LARGE = 400

import os, sys, inspect
# realpath() will make your script run, even if you symlink it :)
cmd_folder = os.path.realpath(os.path.abspath(os.path.split(inspect.getfile( inspect.currentframe() ))[0]))
if cmd_folder not in sys.path:
	sys.path.insert(0, cmd_folder)


import rest as _rest
import error as _error

FotoliaApi = _rest.Rest
ApiError = _error.ApiError
