package org.webservice.fotolia;

import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

public class FotoliaCreateMemberQuery extends HashMap<String, String>
{
    /**
     * Constructor
     *
     * @param  login
     * @param  password
     * @param  email
     * @param  language_id
     */
    public FotoliaCreateMemberQuery(final String login, final String password, final String email, final int language_id)
    {
        this.put("login", login);
        this.put("password", password);
        this.put("email", email);
        this.put("language_id", Long.toString(language_id));
    }

    /**
     * Sets the display name property
     *
     * @param  display_name
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setDisplayName(final String display_name)
    {
        this.put("display_name", display_name);
        return this;
    }

    /**
     * Sets the first name property
     *
     * @param  firstname
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setFirstName(final String firstname)
    {
        this.put("firstname", firstname);
        return this;
    }

    /**
     * Sets the last name property
     *
     * @param  lastname
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setLastName(final String lastname)
    {
        this.put("lastname", lastname);
        return this;
    }

    /**
     * Sets the address property
     *
     * @param  address
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setAddress(final String address)
    {
        this.put("address", address);
        return this;
    }

    /**
     * Sets the ZIP code property
     *
     * @param  zipcode
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setZipCode(final String zipcode)
    {
        this.put("zipcode", zipcode);
        return this;
    }

    /**
     * Sets the city property
     *
     * @param  city
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setCity(final String city)
    {
        this.put("city", city);
        return this;
    }

    /**
     * Sets the country ID property
     *
     * @param  country_id
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setCountryId(final Long country_id)
    {
        this.put("country_id", Long.toString(country_id));
        return this;
    }

    /**
     * Sets the newsletter property
     *
     * @param  newsletter
     * @return FotoliaCreateMemberQuery
     */
    public FotoliaCreateMemberQuery setNewsletter(final Boolean newsletter)
    {
        this.put("newsletter", newsletter ? "1" : "0");
        return this;
    }

    /**
     * Returns a Fotolia API args from this class
     *
     * @return FotoliaApiArgs
     */
    public FotoliaApiArgs getFotoliaApiArgs()
    {
        FotoliaApiArgs args;
        Iterator iter;
        Map.Entry entry;

        args = new FotoliaApiArgs();
        iter = this.entrySet().iterator();
        while (iter.hasNext()) {
            entry = (Map.Entry) iter.next();

            args.add(new BasicNameValuePair("properties[" + (String) entry.getKey() + "]", (String) entry.getValue()));
        }

        return args;
    }
}
