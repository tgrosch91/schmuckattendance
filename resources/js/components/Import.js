import React, { Component } from 'react';
import classNames from 'classnames';
import Dropzone from 'react-dropzone';
import axios from 'axios';
import DatePicker from 'react-16-bootstrap-date-picker';
import Select from 'react-select';


export default class Import extends Component {
  constructor(props){
    super(props);
    this.state = {
      data: [],
      date: '',
      importType: { value: 1, label: 'Absent'},
      importMessage: ''
    };
    this.onDrop=this.onDrop.bind(this);
    this.handleImportTypeChange = this.handleImportTypeChange.bind(this);
  }
   onDrop = (acceptedFiles, rejectedFiles) => {
     const file = acceptedFiles[0];
     const data = new FormData();
     data.append('file', file, file.name);
     data.append('date', this.state.date);
     data.append('type', this.state.importType.value);
     return axios.post(`/api/import`, data, {
       headers: {
         'Content-Type': `multipart/form-data; boundary=${data._boundary}`,
       },
       timeout: 30000,
     }).then((response) => {
       this.setState({
         importMessage: response.data
       });
     }).catch(errors =>{
       this.setState({ importMessage: 'Error importing' });
       console.log(errors);
     });
   };
   handleChange = (value, formattedValue) => {
    this.setState({
      date: formattedValue // Formatted String, ex: "11/19/2016"
    });
  }
  handleImportTypeChange(selectedOption){
    this.setState({ importType: selectedOption });
  }

   render() {
     const importTypes = [
       { value: 1, label: 'Absent' },
       { value: 2, label: 'Tardy' },
       { value: 3, label: 'Early Dismissal' },
       { value: 4, label: 'Tardy to Class' },
     ];
    return (
      <div>
      <DatePicker id="example-datepicker" dateFormat="YYYY-MM-DD" value={this.state.date} onChange={this.handleChange}/>
      <Select
        value={this.state.importType.value}
        onChange={this.handleImportTypeChange}
        placeholder={this.state.importType.label}
        options={importTypes}
      />
      <Dropzone onDrop={this.onDrop}>
        {({getRootProps, getInputProps, isDragActive}) => {
          return (
            <div
              {...getRootProps()}
              className={classNames('dropzone', {'dropzone--isActive': isDragActive})}
            >
              <input {...getInputProps()} />
              {
                isDragActive ?
                  <p>Drop files here...</p> :
                  <p>Try dropping some files here, or click to select files to upload.</p>
              }
            </div>
          )
        }}
      </Dropzone>
      <div>{this.state.importMessage}</div>
      </div>
    );
  }
}
