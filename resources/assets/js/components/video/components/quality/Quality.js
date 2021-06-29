import React, { Component, PropTypes } from 'react'

class Quality extends Component {
    render() {
        return (
            <div className={'vjs-menu-button vjs-menu-button-popup vjs-control vjs-button'}>
                <button className={'vjs-menu-button vjs-menu-button-popup vjs-button'}>
                    <i className={'fas fa-cog'}></i>
                </button>
                <div className={'vjs-menu'}>
                    <ul className={'vjs-menu-content'}>
                        <li className={'vjs-menu-item'}>
                            <span className={'vjs-menu-item-text'}>720 p</span>
                        </li>
                        <li className={'vjs-menu-item'}>
                            <span className={'vjs-menu-item-text'}>480 p</span>
                        </li>
                        <li className={'vjs-menu-item'}>
                            <span className={'vjs-menu-item-text'}>360 p</span>
                        </li>
                    </ul>
                </div>
            </div>
        )
    }
}

export default Quality;
