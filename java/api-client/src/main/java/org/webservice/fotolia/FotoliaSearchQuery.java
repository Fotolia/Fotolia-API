package org.webservice.fotolia;

import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import org.apache.http.message.BasicNameValuePair;

public class FotoliaSearchQuery extends HashMap<String, String>
{
    /**
     * Constructor
     *
     * @param  words
     */
    public FotoliaSearchQuery()
    {
    }

    /**
     * Constructor
     *
     * @param  words
     */
    public FotoliaSearchQuery(final String words)
    {
        this.setWords(words);
    }

    /**
     * Sets the searched phrase
     *
     * @param  words
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setWords(final String words)
    {
        this.put("words", words);
        return this;
    }

    /**
     * Set the language ID
     *
     * @param  language_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLanguageId(final int language_id)
    {
        this.put("language_id", Long.toString(language_id));
        return this;
    }

    /**
     * Set the creator ID
     *
     * @param  creator_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setCreatorId(final int creator_id)
    {
        this.put("creator_id", Long.toString(creator_id));
        return this;
    }

    /**
     * Set the cat1 ID
     *
     * @param  cat1_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setCat1Id(final long cat1_id)
    {
        this.put("cat1_id", Long.toString(cat1_id));
        return this;
    }

    /**
     * Set the cat2 ID
     *
     * @param  cat2_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setCat2Id(final long cat2_id)
    {
        this.put("cat2_id", Long.toString(cat2_id));
        return this;
    }

    /**
     * Set the gallery ID
     *
     * @param  gallery_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setGalleryId(final String gallery_id)
    {
        this.put("gallery_id", gallery_id);
        return this;
    }

    /**
     * Set the country ID
     *
     * @param  country_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setCountryId(final int country_id)
    {
        this.put("country_id", Long.toString(country_id));
        return this;
    }

    /**
     * Set the media ID
     *
     * @param  media_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setMediaId(final long media_id)
    {
        this.put("media_id", Long.toString(media_id));
        return this;
    }

    /**
     * Set the model ID
     *
     * @param  model_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setModelId(final long model_id)
    {
        this.put("model_id", Long.toString(model_id));
        return this;
    }

    /**
     * Set the serie ID
     *
     * @param  serie_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setSerieId(final long serie_id)
    {
        this.put("serie_id", Long.toString(serie_id));
        return this;
    }

    /**
     * Set the similia ID
     *
     * @param  similia_id
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setSimiliaId(final long similia_id)
    {
        this.put("similia_id", Long.toString(similia_id));
        return this;
    }

    /**
     * Set the offset
     *
     * @param  offset
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setOffset(final long offset)
    {
        this.put("offset", Long.toString(offset));
        return this;
    }

    /**
     * Set the limit
     *
     * @param  limit
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLimit(final int limit)
    {
        this.put("limit", Long.toString(limit));
        return this;
    }

    /**
     * Set the order
     *
     * @param  order
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setOrder(final String order)
    {
        this.put("order", order);
        return this;
    }

    /**
     * Set the thumbnail size
     *
     * @param  thumbnail_size
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setThumbnailSize(final int thumbnail_size)
    {
        this.put("thumbnail_size", Long.toString(thumbnail_size));
        return this;
    }

    /**
     * Set the details level
     *
     * @param  detail_level
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setDetailsLevel(final boolean detail_level)
    {
        this.put("detail_level", Long.toString(detail_level ? 1 : 0));
        return this;
    }

    /**
     * Set the photo filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setPhotoFilter(final boolean flag)
    {
        this.put("filters][content_type:photo", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the illustration filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setIllustrationFilter(final boolean flag)
    {
        this.put("filters][content_type:illustration", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the vector filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setVectorFilter(final boolean flag)
    {
        this.put("filters][content_type:vector", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the video filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setVideoFilter(final boolean flag)
    {
        this.put("filters][content_type:video", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Remove any content filters previously set
     *
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setRemoveAllContentFilters()
    {
        this.setVideoFilter(true).setVectorFilter(true).setIllustrationFilter(true).setPhotoFilter(true);
        return this;
    }

    /**
     * Set the offensive filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setOffensiveFilter(final boolean flag)
    {
        this.put("filters][offensive:2", Long.toString(flag ? 0 : 1));
        return this;
    }

    /**
     * Set the isolated filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setIsolatedFilter(final boolean flag)
    {
        this.put("filters][isolated:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the panoramic filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setPanoramicFilter(final boolean flag)
    {
        this.put("filters][panoramic:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license L filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseLFilter(final boolean flag)
    {
        this.put("filters][license_L:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license XL filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseXLFilter(final boolean flag)
    {
        this.put("filters][license_XL:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license XXL filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseXXLFilter(final boolean flag)
    {
        this.put("filters][license_XXL:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license X filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseXFilter(final boolean flag)
    {
        this.put("filters][license_X:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license V_HD1080 filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseHD1080Filter(final boolean flag)
    {
        this.put("filters][license_V_HD1080:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the license V_HD720 filter
     *
     * @param flag
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setLicenseHD720Filter(final boolean flag)
    {
        this.put("filters][license_V_HD720:on", Long.toString(flag ? 1 : 0));
        return this;
    }

    /**
     * Set the orientation filter
     *
     * @param orientation
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setOrientationFilter(final String orientation)
    {
        this.put("filters][orientation", orientation);
        return this;
    }

    /**
     * Set the age filter
     *
     * @param age
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setAgeFilter(final String age)
    {
        this.put("filters][age", age);
        return this;
    }

    /**
     * Set the video duration filter
     *
     * @param video_duration
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setVideoDurationFilter(final String video_duration)
    {
        this.put("filters][videoduration", video_duration);
        return this;
    }

    /**
     * Set the max_price_xs filter
     *
     * @param max_price_xs
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setMax_Price_XsFilter(final int max_price_xs)
    {
        this.put("filters][max_price_xs", Long.toString(max_price_xs));
        return this;
    }

    /**
     * Set the max_price_x filter
     *
     * @param max_price_x
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setMax_Price_XFilter(final int max_price_x)
    {
        this.put("filters][max_price_x", Long.toString(max_price_x));
        return this;
    }

    /**
     * Set the colors filter
     *
     * @param colors
     * @return FotoliaSearchQuery
     */
    public FotoliaSearchQuery setColorsFilter(final String colors)
    {
        this.put("filters][colors", colors);
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

            args.add(new BasicNameValuePair("search_parameters[" + (String) entry.getKey() + "]", (String) entry.getValue()));
        }

        return args;
    }
}
