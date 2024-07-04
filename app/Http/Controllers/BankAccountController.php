<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Http\Requests\BankAccountRequest;

class BankAccountController extends Controller
{
    public function index(){
        $accounts = BankAccount::where('user_id', auth()->user()->id)->get();

        return view('bank_account.list', compact('accounts'));
    }
    public function new(){
        return view('bank_account.register');
    }

    public function transactions($id){
        $account = BankAccount::find($id);
        if(!$account) return back()->with('danger', 'Conta não encontrada');

        $profit = Transaction::where(function($query) {
            $query->where('type', 'Entrada')
                ->orWhere('type', 'Empréstimo (Entrada)');
        })
        ->where('bank_account_id', $id)
        ->sum('value');

        $loss = Transaction::where(function($query) {
            $query->where('type', 'Saída')
                ->orWhere('type', 'Empréstimo (Saída)');
        })
        ->where('bank_account_id', $id)
        ->sum('value');



        $balance = number_format(($profit - $loss), 2, ',', '.');

        $profit = number_format($profit, 2, ',', '.');
        $loss = number_format($loss, 2, ',', '.');


        return view('dashboard', compact('profit', 'loss', 'balance', 'account'));
    }

    public function save(BankAccountRequest $request){
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $account = BankAccount::create($data);
        return redirect("/bank-account/edit/$account->id")->with("success", "Conta criada");
    }

    public function update(BankAccountRequest $request){
        $data = $request->validated();
        $account = BankAccount::find($request->id);
        $account->update($data);
        return back()->with("success", "Conta atuazalida");
    }

    public function edit($id){
        $account = BankAccount::find($id);
        if(!$account) return back()->with('danger', 'Conta não encontrada');
        return view('bank_account.register', compact('account'));
    }

    public function delete($id){
        $account = BankAccount::find($id);
        if(!$account) return back()->with('danger', 'Conta não encontrada');
        $account->delete();
        return back()->with('success', "Conta apagada");
    }
}
