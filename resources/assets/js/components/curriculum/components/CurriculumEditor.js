import React, {Component} from 'react';
import TinyMCE from 'react-tinymce';
import _ from 'lodash';
import * as api from './../api'
import axios from 'axios';

class CurriculumEditor extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            description: ''
        }
        this.handleDescriptionChange = this.handleDescriptionChange.bind(this);
        this.closeTinyMce = this.closeTinyMce.bind(this);
        this.onSubmitTinyMCE = this.onSubmitTinyMCE.bind(this);
    }

    /**
     * Send onchange handle to parent component
     */
    handleDescriptionChange(e) {
        let description = e.target.getContent();
        this.setState({description})
    }

    closeTinyMce(value, status) {
        this.props.closeTinyMce(value, status);
    }

    onSubmitTinyMCE(value) {
        return e => {
            e.preventDefault();
            let {description} = this.state;
            
            axios.post(api.UPDATE_DESCRIPTION, {
                value,
                description
            })
            .then((response) => {
                if (response.status === 200) {
                    this.props.onSubmitTinyMCE(value, description)
                }
            })
            .catch((error) => {
                console.log(error);
            })
        }
    }

    render() {
        const {value} = this.props
        return(
            <form onSubmit={this.onSubmitTinyMCE(value)}>
                <p>{this.props.title}</p>
                <TinyMCE
                    content={_.isNull(value.description) ? '' : value.description}
                    config={{
                        toolbar: 'bold italic',
                        menubar: false,
                        statusbar: false,
                        theme: 'modern'
                    }}
                    onChange={this.handleDescriptionChange}
                />
                <br/>
                <div className="text-right form-actions">
                    <button 
                        className="btn btn-link"
                        onClick={() => this.closeTinyMce(value, false)}
                    > Đóng</button>
                    <button className="btn btn-primary" type="submit"> Lưu lại</button>
                </div>
            </form>
        )
    }
}

export default CurriculumEditor;