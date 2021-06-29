import React from 'react';
import videojs from 'video.js';
require('videojs-contrib-hls');

import { forEach as _forEach } from 'lodash';

const vjsComponent = videojs.getComponent('Component');

export default class VideoPlayer extends React.Component {
    defaultProps = {
        eventListeners: {}
    };
    componentDidMount() {
        // instantiate Video.js
        this.player = videojs(this.videoNode, this.props, function onPlayerReady() {
            console.log('onPlayerReady', this);
        });

        _forEach(this.props.eventListeners, (callback, name) => this.player.on(name, callback))
    }

    // destroy player on unmount
    componentWillUnmount() {
        if (this.player) {
            this.player.dispose()
        }
    }

    // wrap the player in a div with a `data-vjs-player` attribute
    // so videojs won't create additional wrapper in the DOM
    // see https://github.com/videojs/video.js/pull/3856
    render() {
        return (
            <div data-vjs-player>
                <video ref={node => this.videoNode = node} className="video-js"></video>
            </div>
        )
    }
}