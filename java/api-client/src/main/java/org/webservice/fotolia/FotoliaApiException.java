package org.webservice.fotolia;

import org.apache.http.annotation.Immutable;
import org.apache.http.client.ClientProtocolException;

/**
 * Signals a non 2xx HTTP response.
 *
 * @since 4.0
 */
@Immutable
public class FotoliaApiException extends ClientProtocolException
{
    private final int _error_code;

    public FotoliaApiException(int error_code, final String s)
    {
        super(s);
        this._error_code = error_code;
    }

    public int getStatusCode() {
        return this._error_code;
    }
}
