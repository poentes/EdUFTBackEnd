<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\LivrosInterface as LivrosInterface;
use App\Models\Livros;
use App\Models\Produtos;
use App\Models\Opinioes;
use App\Models\Autores;

class LivrosRepository extends Repository implements LivrosInterface
{
  /**
   * @var Model
   */
  protected $model;
 
  /**
   * Constructor
   */
  public function __construct(Livros $model)
  {
    $this->model = $model;
  }


  public function persist($data)
  {
    return $this->model->create($data);
  }

  public function persistProduto($data)
  {
    $opinioes = new Opinioes('', 0);
    $opinioes->save();
    
    $data['opiniao'] = $opinioes->id;

    $prod =['titulo' => $data['titulo'], 'valor' => $data['valor'],'peso' => $data['peso'],'descricao' =>$data['descricao'], 
            'categoria' => $data['categoria'], 'quantidade' => $data['quantidade'], 'opiniao' => $data['opiniao'] ];

    //dd($prod);  

    $produto = new Produtos($prod);

    $produto->save();
    $data['produto'] = $produto->id;


    $l = ['titulo' =>$data['titulo'], 'sinopse' => $data['sinopse'],'anopublicacao' => $data['anopublicacao'],
    'area' => $data['area'],'image' => $data['image'],'produto' => $data['produto']];

    $livro = new Livros($l);
    $livro->save();

    
    $autores = $data['autor'];

    $autoresPersist = array();

    foreach ($autores as $autor) 
    {
      /*array_push($autoresPersist, Autores::find($autor));

      $users = DB::table('autores_livros')
                ->insert(['livro' => $livro->id, 'autor' => $autor]);*/
      $livro->autores()->attach($autor); 
    }

    //$autores_livros = DB::table('autores_livros')->select('livro', 'autor')
      //                    ->where('livro', '==', $livro->id)->get();

    //dd($autores_livros);
    //dd($autoresPersist);

    //$autor = Autores::find($data['autor']);
    
    //$livro->autores()->attach($autor->id);

    return $livro;
  }
}
