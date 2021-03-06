import React, {Component} from 'react';
import TinyMCE from 'react-tinymce';
import * as api from './../../api';
import ToggleButton from 'react-toggle-button'

class TestAdd extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            testTitle: '',
            testDescription: '',
            random: false,
            time: 0,
            score: 0
        }

        this.addNewTest = this.addNewTest.bind(this);
        this.changeTestTitle = this.changeTestTitle.bind(this);
        this.changeTestDesc = this.changeTestDesc.bind(this);
        this.changeScore = this.changeScore.bind(this);
        this.changeTime = this.changeTime.bind(this);
        this.testFormStatusListening = this.testFormStatusListening.bind(this)
    }

    changeTestTitle(e) {
        let testTitle = e.target.value;
        this.setState({
            testTitle
        })
    }

    changeTestDesc(e) {
        let testDescription = e.target.getContent();
        this.setState({
            testDescription
        })
    }

    changeTime(e) {
        let time = e.target.value;
        this.setState({time})
    }

    changeScore(e) {
        let score = e.target.value;
        this.setState({score})
    }

    testFormStatusListening(value) {
        this.props.testFormStatusListening(value);
    }

    changeToggleRandom() {
        let {random} = this.state;
        this.setState({random: !random})
    }

    addNewTest(type) {
        return event => {
            event.preventDefault()
            let {testDescription, testTitle, time, score, random} = this.state;
            if (!_.isNaN(testTitle) && time > 0) {
                axios.post(api.ADD_ITEM, {
                    course_id: this.props.cId,
                    name: testTitle,
                    description: testDescription,
                    type,
                    time, 
                    score,
                    random: (random === true) ? 'active' : 'disable',
                    userid: this.props.userid
                })
                .then((response) => {
                    if (response.status === 200) {
                        this.setState({
                            testTitle: '',
                            testDescription: '',
                        })
                        this.props.testFormStatusListening(false);
                        this.props.quizAdded(response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        }
    }

    render() {
        return(
            <div className="form-wrapper">
                <form className="form-section" onSubmit={this.addNewTest('test')}>
                    <div style={{display: 'flex'}}>
                        <div className="form-title">
                            B??i t???p
                        </div>
                        <div className="form-content">
                            <label>Ti??u ?????</label>
                            <div className="form-group form-group-sm">
                                <input 
                                    maxLength="80" 
                                    placeholder="Nh???p ti??u ?????" 
                                    className="form-control" 
                                    type="text" 
                                    value={this.state.testTitle}
                                    onChange={this.changeTestTitle}
                                    required
                                />
                            </div>

                            <label>Mi??u t???</label>
                            <TinyMCE
                                content={this.state.testDescription}
                                config={{
                                    toolbar: 'bold italic',
                                    menubar: false,
                                    statusbar: false,
                                    theme: 'modern'
                                }}
                                onChange={this.changeTestDesc}
                            />

                            <label>Th???i gian (ph??t)</label>
                            <div className="form-group form-group-sm">
                                <input 
                                    className="form-control" 
                                    type="number" 
                                    value={this.state.time}
                                    onChange={this.changeTime}
                                    required
                                />
                            </div>

                            <label>??i???m t???i ??a c???n ?????t (%)</label>
                            <div className="form-group form-group-sm">
                                <input 
                                    className="form-control" 
                                    type="number" 
                                    value={this.state.score}
                                    onChange={this.changeScore}
                                    required
                                />
                            </div>
                            
                            <label>Tr???n th??? t??? c??u h???i & c??u tr??? l???i</label>
                            <div className="form-group form-group-sm">
                                <div className="toggle-item">
                                    <ToggleButton
                                        value={this.state.random}
                                        onToggle={() => this.changeToggleRandom()} 
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="text-right form-actions">
                        <button 
                            className="btn btn-link"
                            type="button"
                            onClick={() => this.testFormStatusListening(false)}
                        > ????ng</button>
                        <button className="btn btn-primary" type="submit"> Th??m b??i t???p</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default TestAdd;