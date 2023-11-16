import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';


registerBlockType('news-feed-gutenberg/news-block', {
    title: 'News Block',
    icon: 'universal-access-alt',
    category: 'widgets',
    edit: ( props ) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;
        const { __ } = wp.i18n;
        return(
            <div { ...blockProps }>
                <SelectControl
                    label={__("Choose country", 'news_feed_gutenberg')}
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
                        country: attributes.country
                    }}
                />
            </div>
        )
    },
});