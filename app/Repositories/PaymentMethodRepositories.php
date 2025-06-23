<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\PaymentMethod;

class PaymentMethodRepositories
{
    static protected $paymentMethod = PaymentMethod::class;

    static protected  function userActive()
    {
        return auth()->guard()->user();
    }

    static public function setup()
    {
        $user = self::userActive();

        if ($user != null && $user->role->value == "store") {
            $payment = self::$paymentMethod::all();

            if ($payment->isEmpty()) {
                self::$paymentMethod::create([
                    'user_id' => $user->id,
                    'name' => 'COD',
                    'account_number' => 'Cash On Delivery',
                    'is_default' => true,
                ]);
            }
        }
    }

    static public function getAllPaymentMethod()
    {
        return self::userActive()->paymentMethods->toArray();
    }

    static public function getPaymentMethodByID(int $paymentMethodID)
    {
        return self::$paymentMethod::find($paymentMethodID)->toArray();
    }

    static public function createPaymentMethod(array $input)
    {
        try {
            self::$paymentMethod::create([
                'user_id' => self::userActive()->id,
                'name' => $input['name'],
                'account_number' => $input['account_number'],
                'is_default' => false,
            ]);

            return redirect()->route('store.tambah_metode_pembayaran')->with('success', 'Berhasil menambahkan Metode Pembayaran Baru');
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }

    static public function updatePaymentMethod(int $paymentMethodID, array $input)
    {
        $payment = self::$paymentMethod::find($paymentMethodID);

        if (!$payment) {
            return redirect()->route('store.tambah_metode_pembayaran')->with('danger', 'Data Metode Pembayaran tidak ditemukan');
        }

        try {

            $payment->fill($input);

            if (!$payment->isDirty()) {
                return back()->with('danger', 'Tidak ada data yang dirubah.');
            }

            $payment->save();

            return redirect()->route('store.tambah_metode_pembayaran')->with('success', 'Berhasil mengubah Metode Pembayaran Baru');
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }

    static public function deletePaymentMethod(int $paymentMethodID)
    {
        $paymentUsed = Order::where('payment_method_id', $paymentMethodID)->get()->isNotEmpty();

        if ($paymentUsed) {
            return redirect()->route('store.tambah_metode_pembayaran')->with('danger', 'Tidak Bisa Hapus. Data Metode Pembayaran telah digunakan');
        }

        $payment = self::$paymentMethod::find($paymentMethodID);

        if (!$payment) {
            return redirect()->route('store.tambah_metode_pembayaran')->with('danger', 'Data Metode Pembayaran tidak ditemukan');
        }

        try {
            $payment->delete();

            return redirect()->route('store.tambah_metode_pembayaran')->with('success', 'Berhasil mengubah Metode Pembayaran Baru');
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
}
