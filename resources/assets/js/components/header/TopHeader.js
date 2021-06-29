/**
 * Created by Admin on 4/5/2018.
 */
import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class TopHeader extends Component {
	render() {
		return (
			<div className="top-header">
				<div className="container">
					<div className="main">
						<div className="content">
							<a href="#" className="">
							Learn From the Best
							<span>|</span>
							Build your skills with the help of expert instructors for courses as low as $11.99 1 day left
							</a>
						</div>
						<span className="icon-close"><i className="fas fa-times"></i></span>
					</div>
				</div>
			</div>
		);
	}
}

export default TopHeader;

if (document.getElementById('TopHeader')) {
	ReactDOM.render(<TopHeader />, document.getElementById('TopHeader'));
}

