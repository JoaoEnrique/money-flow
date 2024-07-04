<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransitionRequest;
use App\Models\Transaction;
use App\Models\BankAccount;

class TransactionController extends Controller
{
    public function index($type){
        if ($type == 'profit') {
            $transactions = Transaction::where(function($query) {
                    $query->where('type', 'Entrada')
                          ->orWhere('type', 'Empréstimo (Entrada)');
                })
                ->where('user_id', auth()->user()->id)
                ->get();
        } elseif ($type == 'loss') {
            $transactions = Transaction::where(function($query) {
                    $query->where('type', 'Saída')
                          ->orWhere('type', 'Empréstimo (Saída)');
                })
                ->where('user_id', auth()->user()->id)
                ->get();
        } elseif ($type == 'all') {
            $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        }


        return view('transaction.list', compact('transactions'));
    }

    public function dashboard(){
        $profit = Transaction::where(function($query) {
            $query->where('type', 'Entrada')
                  ->orWhere('type', 'Empréstimo (Entrada)');
        })
        ->where('user_id', auth()->user()->id)
        ->where('show', true)
        ->sum('value');

        $loss = Transaction::where(function($query) {
            $query->where('type', 'Saída')
                ->orWhere('type', 'Empréstimo (Saída)');
        })
        ->where('user_id', auth()->user()->id)
        ->where('show', true)
        ->sum('value');


        $balance = number_format(($profit - $loss), 2, ',', '.');

        $profit = number_format($profit, 2, ',', '.');
        $loss = number_format($loss, 2, ',', '.');
        
        return view('dashboard', compact('profit', 'loss', 'balance'));
    }

    public function dashboardValueHidden(){
        $profit = Transaction::where(function($query) {
            $query->where('type', 'Entrada')
                  ->orWhere('type', 'Empréstimo (Entrada)');
        })
        ->where('user_id', auth()->user()->id)
        ->where('show', false)
        ->sum('value');

        $loss = Transaction::where(function($query) {
            $query->where('type', 'Saída')
                ->orWhere('type', 'Empréstimo (Saída)');
        })
        ->where('user_id', auth()->user()->id)
        ->where('show', false)
        ->sum('value');


        $balance = number_format(($profit - $loss), 2, ',', '.');

        $profit = number_format($profit, 2, ',', '.');
        $loss = number_format($loss, 2, ',', '.');

        $hidden = true;
        return view('dashboard', compact('profit', 'loss', 'balance', 'hidden'));
    }

    public function new(){
        $accounts = BankAccount::where('user_id', auth()->user()->id)->get();
        return view('transaction.register', compact('accounts'));
    }

    public function save(TransitionRequest $request){
        $data = $request->validated();
        $data['show'] = $request->has('show');
        $data['user_id'] = auth()->user()->id;
        $transaction = Transaction::create($data);
        $transaction->bank_account_id = $request->bank_account_id != 'null' ? $request->bank_account_id : null;
        $transaction->save();
        return redirect("/transaction/edit/$transaction->id")->with("success", "Transição criada");
    }

    public function update(TransitionRequest $request){
        $data = $request->validated();
        $data['show'] = $request->has('show');
        $transaction = Transaction::find($request->id);
        $transaction->update($data);
        $transaction->bank_account_id = $request->bank_account_id != 'null' ? $request->bank_account_id : null;
        $transaction->save();
        return back()->with("success", "Transição atuazalida");
    }

    public function edit($id){
        $transaction = Transaction::find($id);
        $accounts = BankAccount::where('user_id', auth()->user()->id)->get();
        if(!$transaction) return back()->with('danger', 'Transação não encontrada');
        return view('transaction.register', compact('transaction', 'accounts'));
    }

    public function delete($id){
        $transaction = Transaction::find($id);
        if(!$transaction) return back()->with('danger', 'Transação não encontrada');
        $transaction->delete();
        return back()->with('success', "Transação apagada");
    }
}
