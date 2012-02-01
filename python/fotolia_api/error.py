class ApiError(Exception):
    """
    API error exception class
    """

    code = 0

    def __init__(self, value, code):
        self.value = value
        self.code = code

    def __str__(self):
        return repr(self.value)

    def get_code(self):
        return code
