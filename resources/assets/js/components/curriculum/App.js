import React, {Component} from 'react';
import ReactDom from 'react-dom';
import registerServiceWorker from './../../registerServiceWorker';
import Curriculum from './components/Curriculum';

if (document.getElementById('Curriculum')) {

    const element = document.getElementById('Curriculum')
        
    const props = Object.assign({}, element.dataset)

    ReactDom.render(
        <Curriculum {...props}/>,
        element
    );
    registerServiceWorker();
}




