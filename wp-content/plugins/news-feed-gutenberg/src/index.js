import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { TextControl, SelectControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';


registerBlockType('news-feed-gutenberg/news-block', {
    title: 'News Block',
    icon: 'universal-access-alt',
    category: 'widgets',
    'attributes': {
        'apikey': {
            'type': 'string',
            'default': 'd77f778d6d4643ebb53fc72ce08513c1',
        },
        'pageSize': {
            'type': 'integer',
            'default': 3,
        },
        'country': {
            'type': 'string',
            'default': 'us',
        },
        'category': {
            'type': 'string',
            'default': 'general',
        },
    },
    edit: ( props ) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;
        const { __ } = wp.i18n;
        return(
            <div { ...blockProps }>
                <TextControl 
                    label={__("API Key", 'news_feed_gutenberg')}
                    type="string"
                    value={attributes.apikey}
                    onChange={(value) => setAttributes({ apikey: value })}
                />
                <TextControl 
                    label={__("News Number", 'news_feed_gutenberg')}
                    type="string"
                    value={attributes.pageSize}
                    onChange={(value) => setAttributes({ pageSize: value })}
                />
                <SelectControl
                    label={__("Set Default Country", 'news_feed_gutenberg')}
                    value={attributes.country}
                    options={[
                        { label: 'USA', value: 'us' },
                        { label: 'Ukraine', value: 'ua' },
                    ]}
                    onChange={(value) => setAttributes({ country: value })}
                />
                <SelectControl
                    label={__("Set Default Category", 'news_feed_gutenberg')}
                    value={attributes.category}
                    options={[
                        { label: 'Business', value: 'business' },
                        { label: 'Science', value: 'science' },
                        { label: 'Sports', value: 'sports' },
                        { label: 'General', value: 'general' },
                    ]}
                    onChange={(value) => setAttributes({ category: value })}
                />
                <ServerSideRender
                    block="news-feed-gutenberg/news-block"
                    attributes={{
                        apikey: attributes.apikey,
                        pageSize: attributes.pageSize,
                        country: attributes.country,
                        category: attributes.category,
                    }}
                />
            </div>
        )
    },
});