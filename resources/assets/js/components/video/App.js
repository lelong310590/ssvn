import React, {Component} from 'react';
import ReactDom from 'react-dom';
import registerServiceWorker from './../../registerServiceWorker';
import Single from './components/Single';

if (document.getElementById('Single')) {

    const element = document.getElementById('Single')
        
    const props = Object.assign({}, element.dataset)

    ReactDom.render(
        <Single {...props}/>,
        element
    );
    registerServiceWorker();
}