package org.webservice.fotolia;

import java.util.ArrayList;
import java.util.List;
import java.io.UnsupportedEncodingException;

import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.protocol.HTTP;
import org.apache.http.client.utils.URLEncodedUtils;

public class FotoliaApiArgs extends ArrayList<NameValuePair>
{
    /**
     * Generate a UrlEncodedFormEntity from the arguments
     *
     * @return UrlEncodedFormEntity
     */
    public UrlEncodedFormEntity getUrlEncodedFormEntity() throws UnsupportedEncodingException
    {
        return new UrlEncodedFormEntity(this, HTTP.UTF_8);
    }

    /**
     * Convert the parameters into a String
     *
     * @return String
     */
    public String toString()
    {

        return URLEncodedUtils.format(this, HTTP.UTF_8);
    }
}
