import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Button } from 'react-bootstrap';

export default class Letter extends Component {
  constructor(props){
    super(props);
  }

  deleteLetter(e,id){
    e.preventDefault();
    this.props.deleteLetter(id)
  }

    render() {
      const letter = this.props.letter;
        return (
          <div key={letter.id}>
            <li>{letter.name} <Button onClick={(evt) => this.deleteLetter(evt, letter.id)}>DELETE</Button> </li>
          </div>
        );
    }
}
