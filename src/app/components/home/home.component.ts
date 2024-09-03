import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Contato } from 'src/models/contato';
import { FormControl, FormGroup } from '@angular/forms';
import { HomeService } from './home.service';
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
})
export class HomeComponent {
  cadastro = new FormGroup({
    nome: new FormControl(''),
    dataNasc: new FormControl(''),
    email: new FormControl(''),
    celular: new FormControl('')
  });

  contatos: Contato[] = [];

  constructor(private http: HttpClient, private homeService: HomeService) {}

  ngOnInit(): void {
    this.http
      .get<Contato[]>('http://localhost/backend/getData.php')
      .subscribe((data) => {
        console.log(data)
        this.contatos = data;
      });
  }

  onSubmit(): void{
    const formValue = this.cadastro.value;
    const newContato: Contato = {
      id: 3, // Assumindo que o ID será gerado pelo backend
      nome: formValue.nome || '',
      dataNasc: formValue.dataNasc || '', // Converter para Date
      email: formValue.email || '',
      celular: formValue.celular || '',
    };
    this.homeService.addContato(newContato).subscribe({
      next: (response) => {
        console.log(response)
        console.log(newContato)
        console.log('deu certo no angular', response);
        this.cadastro.reset();
      },
      error: (err) => {
        console.error('deu erro no angular', err);
      },
    
    })
  }

  onDelete(id: number): void {
    this.homeService.deleteContato(id).subscribe({
      next: (response) => {
        console.log('Contato excluído com sucesso!', response);
        this.contatos = this.contatos.filter(contato => contato.id !== id);
      },
      error: (err) => {
        console.error('Erro ao excluir contato', err);
      }
    });
  }
}
