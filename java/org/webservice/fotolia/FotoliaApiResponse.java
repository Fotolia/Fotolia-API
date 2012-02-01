package org.webservice.fotolia;

import java.io.IOException;

import org.apache.http.annotation.Immutable;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.StatusLine;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.HttpResponseException;
import org.apache.http.util.EntityUtils;

import org.json.simple.JSONValue;
import org.json.simple.JSONObject;

@Immutable
public class FotoliaApiResponse implements ResponseHandler<String>
{

    /**
     * Returns the response body as a String if the response was successful (a
     * 2xx status code). If no response body exists, this returns null. If the
     * response was unsuccessful (>= 300 status code), throws an
     * {@link HttpResponseException}.
     */
    public String handleResponse(final HttpResponse response)
        throws FotoliaApiException, IOException
    {
        StatusLine statusLine = response.getStatusLine();
        HttpEntity entity = response.getEntity();
        JSONObject obj;
        String error_msg;
        int error_code;

        if (statusLine.getStatusCode() != 200) {
            if (entity == null) {
                throw new HttpResponseException(statusLine.getStatusCode(),
                                                statusLine.getReasonPhrase());
            } else {
                obj = (JSONObject) JSONValue.parse(EntityUtils.toString(entity));
                error_msg = (String) obj.get("error");
                if (obj.get("code") != null) {
                    error_code = Integer.parseInt((String) obj.get("code"));
                } else {
                    error_code = statusLine.getStatusCode();
                }

                throw new FotoliaApiException(error_code, error_msg);
            }
        }

        return entity == null ? null : EntityUtils.toString(entity);
    }

}
