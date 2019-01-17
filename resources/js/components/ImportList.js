import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Button } from 'react-bootstrap';

export default class ImportList extends Component {
  constructor(){
    super();
    this.state={
      imports: []
    }
  }
  componentWillMount(){
    axios.get('/api/import').then((response) => {
      this.setState({
        imports: response.data
      });
    }).catch(errors =>{
      console.log(errors);
    })
  }

  deleteImport(e,id){
    e.preventDefault();
    console.log(id);
    let url = '/api/import/'+id;
    axios.delete(url).then((response) => {
      axios.get('/api/import').then((response) => {
        this.setState({
          imports: response.data
        });
      }).catch(errors =>{
        console.log(errors);
      })
    }).catch(errors =>{
      console.log(errors);
    })
  }

    render() {
        return (
            <div className="container" >
            <h3><b>WARNING:</b> Deleting an import will automatically delete
            every record associated with this import.
            This functionality is intended to guard against accidentally
            uploading the same file twice.</h3>
            <br/>
              <ul>
              {this.state.imports.map(imp => (
                <div key={imp.id}>
                  <li>File Name: {imp.file_name}    Date:{imp.date} Uploaded At:   {imp.created_at}  <Button onClick={(evt) => this.deleteImport(evt, imp.id)}>DELETE</Button> </li>
                  <br/>
                </div>
              ))}
              </ul>
            </div>
        );
    }
}
