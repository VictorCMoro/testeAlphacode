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

  editar: boolean = false;
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
      id: Math.floor(Math.random() * 100), 
      nome: formValue.nome || '',
      dataNasc: formValue.dataNasc || '', 
      email: formValue.email || '',
      celular: formValue.celular || '',
    };
    if (this.editar) {
      
      this.onUpdate(newContato);
    } else {
      
      this.homeService.addContato(newContato).subscribe({
        next: (response) => {
          console.log(response);
          console.log('Contato cadastrado com sucesso', response);
          this.cadastro.reset();
          this.editar = false; 
          this.ngOnInit();
        },
        error: (err) => {
          console.error('Erro ao cadastrar contato', err);
        }
      });
    }
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

  onUpdate(contato: Contato): void {
    this.homeService.updateContato(contato).subscribe({
      next: (response) => {
      this.editar = false
        console.log(response)
        console.log('Contato atualizado com sucesso!', response);
        this.ngOnInit();
      },
      error: (err) => {
        console.error('Erro ao atualizar contato', err);
      }
    });
  }

  onEdit(id: number): void {
    this.http.get<Contato>(`http://localhost/backend/getContato.php?id=${id}`)
      .subscribe({
        next: (contato) => {
          this.editar = true
          this.cadastro.patchValue({
            nome: contato.nome,
            dataNasc: contato.dataNasc,
            email: contato.email,
            celular: contato.celular
          });
        },
        error: (err) => {
          console.error('Erro ao buscar contato', err);
        }
      });
  }
}
