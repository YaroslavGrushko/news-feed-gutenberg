import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('news-feed-gutenberg/news-block', {
    title: 'News Block',
    icon: 'universal-access-alt',
    category: 'widgets',
    edit: ( props ) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;
        const { TextControl } = wp.components;
        return(
            <div { ...blockProps }>
                <TextControl 
                    label="Choose country"
                    type="string"
                    value={attributes.country}
                    onChange={(newval) => setAttributes({ country: newval })}
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