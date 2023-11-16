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
                    label="API Key"
                    type="string"
                    value={attributes.apikey}
                    onChange={(value) => setAttributes({ apikey: value })}
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
                <ServerSideRender
                    block="news-feed-gutenberg/news-block"
                    attributes={{
                        apikey: attributes.apikey,
                        country: attributes.country
                    }}
                />
            </div>
        )
    },
});