<?php

namespace App\Controllers;

use App\Models\ModelPelanggan;
use CodeIgniter\RESTful\ResourceController;

class Pelanggan extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelPelanggan = new ModelPelanggan();
        $data = $modelPelanggan->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];
        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
        $modelPelanggan = new ModelPelanggan();
        $data = $modelPelanggan->orLike('id', $cari)
        ->orLike('username', $cari)->get()->getResult();
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
            return $this->failNotFound('maaf data ' . $cari . ' tidak ditemukan');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $modelPelanggan = new ModelPelanggan();
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $nama = $this->request->getPost("nama");
        $email = $this->request->getPost("email");
        $tanggalLahir = $this->request->getPost("tanggalLahir");
        $noTelp = $this->request->getPost("noTelp");

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'username' => [
                'rules' => 'is_unique[pelanggan.username]',
                'label' => 'Username Pelanggan',
                'errors' => [
                    'is_uniqe' => "{field} sudah ada"
                ]
            ]
        ]);

        if (!$valid) {
            $response =[
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("username"),
            ];

            return $this->respond($response, 404);
        } else {
            $modelPelanggan->insert([
                'username' => $username,
                'password' => $password,
                'nama' => $nama,
                'email' => $email,
                'tanggalLahir' => $tanggalLahir,
                'noTelp' => $noTelp,
            ]);

            $response = [
                'status' => 201,
                'error' =>"false",
                'message' => "Data berhasil disimpan"
            ];

            return $this->respond($response, 201);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($username = null)
    {
        $model = new ModelPelanggan();
        $data = [
            'username' => $this->request->getVar("usename"), 
            'nama' => $this->request->getVar("nama"), 
            'email' => $this->request->getVar("email"), 
            'tanggalLahir' => $this->request->getVar("tanggalLahir"),
            'noTelp' => $this->request->getVar("noTelp"),
        ];
        $data = $this->request->getRawInput();
        $model->update($username, $data);
        $response = [
            'status' => 200, 'error' => null, 'message' => "Data Anda $username berhasil dibaharukan"
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelPelanggan = new ModelPelanggan();
        $cekData = $modelPelanggan->find($id);
        if ($cekData) {
            $modelPelanggan->delete($id);
            $response = ['status' => 200, 'error' => null, 'message' => "Selamat data sudah berhasil dihapus maksimal"];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
