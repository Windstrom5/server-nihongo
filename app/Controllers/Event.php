<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\Modelevent;
use App\Controllers\BaseController;

class Event extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $modelEvent = new Modelevent();
        $data = $modelEvent->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }

    public function show($cari = null)
    {
        $modelEvent = new Modelevent();
        $data = $modelEvent->orLike('city', $cari)->get()->getResult();
        if (count($data) > 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else if (count($data) == 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            return $this->failNotFound('maaf data ' . $cari .
                ' tidak ditemukan');
        }
    }
    

    public function create()
    {
        $modelEvent = new Modelevent();
        $namaEvent = $this->request->getPost("namaEvent");
        $alamat = $this->request->getPost("alamat");
        $tgl = $this->request->getPost("tgl");
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namaEvent' => [
                'rules' => 'is_unique[event.namaEvent]',
                'label' => 'Event',
                'errors' => [
                    'is_unique' => "Event {field} sudah ada"
                ]
            ]
        ]);
        if (!$valid) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("namaEvent"),
            ];
            return $this->respond($response, 404);
        } else {
            $modelEvent->insert([
                'namaEvent' => $namaEvent,
                'alamat' => $alamat,
                'tgl' => $tgl,
            ]);
            $response = [
                'status' => 201,
                'error' => "false",
                'message' => "Register Berhasil"
            ];
            return $this->respond($response, 201);
        }
    }

    public function update($namaEvent = null)
    {
        $model = new Modelevent();
        $data = [
            'namaEvent' => $this->request->getVar("namaEvent"),
            'alamat' => $this->request->getVar("alamat"),
            'tgl' => $this->request->getVar("tgl"),
        ];
        $data = $this->request->getRawInput();
        $model->update($namaEvent, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Akun $namaEvent berhasil diupdate"
        ];
        return $this->respond($response);
    }

    public function delete($namaEvent)
    {
        $modelEvent = new Modelevent();
        $cekData = $modelEvent->find($namaEvent);
        if ($cekData) {
            $modelEvent->delete($namaEvent);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Selamat data sudah berhasil dihapus maksimal"
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
