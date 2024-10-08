import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Contato } from 'src/models/contato';

@Injectable({
  providedIn: 'root'
})
export class HomeService {
  private apiUrl = 'http://localhost/backend'

  constructor(private http: HttpClient) { }

  addContato(contato: Contato): Observable<any>{
    return this.http.post(`${this.apiUrl}/createData.php`, contato) 
  }

  deleteContato(id: number): Observable<any>{
    return this.http.delete(`${this.apiUrl}/deleteData.php`, {
      body: {id}
    })
  }

  updateContato(contato: Contato): Observable<any> {
    return this.http.post(`${this.apiUrl}/updateData.php`, contato);
  }
}
