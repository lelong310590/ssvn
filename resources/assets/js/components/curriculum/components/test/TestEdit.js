import React, {Component} from 'react';
import TinyMCE from 'react-tinymce';
import * as api from './../../api';
import ToggleButton from 'react-toggle-button'

class TestEdit extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            id: 0,
            testTitle: '',
            testDescription: '',
            random: false,
            time: 0,
            score: 0
        }

        this.editTest = this.editTest.bind(this)
        this.closeTestEdit = this.closeTestEdit.bind(this);
        this.changeTestTitle = this.changeTestTitle.bind(this);
        this.changeTestDesc = this.changeTestDesc.bind(this);
        this.changeTime = this.changeTime.bind(this);
        this.changeScore = this.changeScore.bind(this);
        this.changeToggleRandom = this.changeToggleRandom.bind(this);
    }

    componentWillMount() {
        let {value} = this.props;
        this.setState({
            id: value.id,
            testTitle: value.name,
            testDescription: value.description,
            random: value.random === 'active' ? true : false,
            time: value.time,
            score: value.score
        })
    }

    closeTestEdit(value) {
        this.props.closeTestEdit(value);
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

    changeToggleRandom() {
        let {random} = this.state;
        this.setState({random: !random})
    }

    editTest(type) {
        return event => {
            event.preventDefault()
            let {id, testDescription, testTitle, time, score, random} = this.state;
            if (!_.isNaN(testTitle) && time > 0) {
                axios.post(api.UPDATE_ITEM, {
                    id,
                    name: testTitle,
                    description: testDescription,
                    type,
                    time,
                    score,
                    random: (random === true) ? 'active' : 'disable'
                })
                    .then((response) => {
                        if (response.status === 200) {
                            this.setState({
                                testTitle: '',
                                testDescription: '',
                            })
                            this.props.closeTestEdit({id, status: false});
                            this.props.testEdited(response.data);
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
                <form className="form-section" onSubmit={this.editTest('test')}>
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
                            onClick={() => this.closeTestEdit({
                                id: this.state.id,
                                status: false
                            })}
                        > ????ng</button>
                        <button className="btn btn-primary" type="submit"> L??u l???i</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default TestEdit;