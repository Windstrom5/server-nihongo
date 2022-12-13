<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\Modeltempatwisata;
use App\Controllers\BaseController;

class TempatWisata extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $modelTW = new Modeltempatwisata();
        $data = $modelTW->findAll();
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
        $modelTW = new Modeltempatwisata();
        $data = $modelTW->orLike('city', $cari)->get()->getResult();
            
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
        $modelTW = new Modeltempatwisata();
        $nama = $this->request->getPost("nama");
        $alamat = $this->request->getPost("alamat");
        $rating = $this->request->getPost("rating");
        $lat = $this->request->getPost("lat");
        $longi = $this->request->getPost("longi");
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'nama' => [
                'rules' => 'is_unique[tempatWisata.nama]',
                'label' => 'Nama Tempat Wisata',
                'errors' => [
                    'is_unique' => "Tempat Wisata {field} sudah ada"
                ]
            ]
        ]);
        if (!$valid) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("nama"),
            ];
            return $this->respond($response, 404);
        } else {
            $modelTW->insert([
                'nama' => $nama,
                'alamat' => $alamat,
                'rating' => $rating,
                'lat' => $lat,
                'longi' => $longi,
            ]);
            $response = [
                'status' => 201,
                'error' => "false",
                'message' => "Register Berhasil"
            ];
            return $this->respond($response, 201);
        }
    }

    public function update($nama = null)
    {
        $model = new Modeltempatwisata();
        $data = [
            'nama' => $this->request->getVar("nama"),
            'alamat' => $this->request->getVar("alamat"),
            'rating' => $this->request->getVar("rating"),
            'lat' => $this->request->getVar("lat"),
            'longi' => $this->request->getVar("longi"),
        ];
        $data = $this->request->getRawInput();
        $model->update($nama, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Akun $nama berhasil diupdate"
        ];
        return $this->respond($response);
    }

    public function delete($nama)
    {
        $modelTW = new ModeltempatWisata();
        $cekData = $modelTW->find($nama);
        if ($cekData) {
            $modelTW->delete($nama);
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
