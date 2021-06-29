import React, { Component } from 'react'
import ReactDom from 'react-dom';
import {BrowserRouter, Route} from 'react-router-dom';
import FirstStep from './steps/FirstStep'
import SecondStep from './steps/SecondStep'
import ThirdStep from './steps/ThirdStep';
import * as api from './api'

class App extends Component {

    constructor(props) {
        super(props);
        this.state = {
            step: 1
        }
    }

    render() {
        let style = '';
        if (this.state.step === 1) {style = '25%'}
        if (this.state.step === 2) {style = '55%'}
        if (this.state.step === 3) {style = '75%'}
        if (this.state.step === 4) {style = '100%'}
        return (
            <div className="create-course-step">
                <div className="header">
                    <div className="logo">
                        <a href="" className="pull-left">
                            <img src="http://vietjack.test/frontend/images/icons/logo.png" alt="" width="" height="" />
                        </a>
                        <div className="step">
                            <span>Bước 1 trong 4</span>
                        </div>
                    </div>
                    <div className="exit">
                        <button type="button">Thoát</button>
                    </div>
                </div>

                <div className="process-wrapper">
                    <div className="process" style={{width: style}}></div>
                </div>

                <BrowserRouter>
                    <div>
                        <Route exact path={api.BASE_URL} component={FirstStep} />
                        <Route exact path={api.BASE_URL + '/buoc2'} component={SecondStep}/>
                        <Route exact path={api.BASE_URL + '/buoc3'} component={ThirdStep}/>
                    </div>
                </BrowserRouter> 
            </div>
        )
    }
}

export default App;

var elem = document.getElementById('createCourse');

if (elem) {
    ReactDom.render(<App/>, elem)
}
