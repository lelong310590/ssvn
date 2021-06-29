import React, {Component} from 'react';
import * as api from "../../api";
import TinyMCE from 'react-tinymce';

class MutichoiceEditor extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            check: 'N',
            content: '',
            index: 0
        }

        this.changeAnswer = this.changeAnswer.bind(this);
        this.addAnswer = this.addAnswer.bind(this);
        this.addNewAnswer = this.addNewAnswer.bind(this);
    }

    componentWillMount() {
        let {answer, index} = this.props;
        this.setState({
            check: answer.check,
            content: answer.content,
            index: index
        })
    }

    addNewAnswer(index) {
        this.props.addNewAnswer(index);
    }

    changeAnswer(e, index) {
       let check = (e.target.checked) ? 'Y' : 'N';
       this.setState({check});
       this.props.changeAnswer(check, index)
    }

    addAnswer(e, index) {
        let content = e.target.getContent();
        this.setState({content})
        this.props.addAnswer(content, index)
    }

    render() {
        let {check, index, content} = this.state;

        return(
            <div className={'answer-content-inner'}>
                <div className="answer-check">
                    <label className="custom-control custom-radio">
                        <input
                            type="checkbox"
                            className="custom-control-input"
                            name="answer"
                            defaultChecked={check ===  'Y'}
                            value={check}
                            onChange={(event) => this.changeAnswer(event, index)}
                        />
                        <span className="custom-control-indicator"></span>
                    </label>
                </div>
                <div className="answer-content-editor">
                    <TinyMCE
                        content={content}
                        config={{
                            plugins: 'autolink link image lists print preview fullscreen',
                            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image | fullscreen',
                            file_browser_callback : function(field_name, url, type, win) {
                                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                                var cmsURL = api.BASE_URL + 'cdn-filemanager?field_name=' + field_name;
                                if (type == 'image') {
                                    cmsURL = cmsURL + "&type=Images";
                                } else {
                                    cmsURL = cmsURL + "&type=Files";
                                }
                                tinyMCE.activeEditor.windowManager.open({
                                    file : cmsURL,
                                    title : 'Filemanager',
                                    width : x * 0.8,
                                    height : y * 0.8,
                                    resizable : "yes",
                                    close_previous : "no"
                                });
                            },
                            language_url: api.BASE_URL + 'frontend/js/vi_VN.js'
                        }}
                        onChange={(event) => this.addAnswer(event, index)}
                        onClick={() => this.addNewAnswer(index)}
                    />
                </div>
            </div>
        )
    }
}

export default MutichoiceEditor