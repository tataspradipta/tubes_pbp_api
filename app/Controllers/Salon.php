<?php

namespace App\Controllers;

use App\Models\ModelSalon;
use CodeIgniter\RESTful\ResourceController;

class Salon extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelSalon = new ModelSalon();
        $data = $modelSalon->findAll();
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
        $modelSalon = new ModelSalon();
        $data = $modelSalon->orLike('id', $cari)
        ->orLike('nama_salon', $cari)->get()->getResult();
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
        $modelSalon = new ModelSalon();
        $id = $this->request->getPost("id");
        $nama_salon = $this->request->getPost("nama_salon");
        $deskripsi = $this->request->getPost("deskripsi");

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nama_salon' => [
                'rules' => 'is_unique[salon.nama_salon]',
                'label' => 'Nama Salon',
                'errors' => [
                    'is_uniqe' => "{field} sudah ada"
                ]
            ]
        ]);

        if (!$valid) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("id"),
            ];

            return $this->respond($response, 404);
        } else {
            $modelSalon->insert([
                'id' => $id,
                'nama_salon' => $nama_salon,
                'deskripsi' => $deskripsi,
            ]);

            $response = [
                'status' => 201,
                'error' => "false",
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
    public function update($id = null)
    {
        $model = new ModelSalon();
        $data = [
            'nama_salon' => $this->request->getVar("nama_salon"),
            'deskripsi' => $this->request->getVar("deskripsi"),
        ];

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nama_salon' => [
                'rules' => 'is_unique[salon.nama_salon]',
                'label' => 'Nama Salon',
                'errors' => [
                    'is_uniqe' => "{field} sudah ada"
                ]
            ]
        ]);

        if (!$valid) {
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("username"),
            ];

            return $this->respond($response, 404);
        } else {
            $data = $this->request->getRawInput();
            $model->update($id, $data);
            $response = [
                'status' => 200, 'error' => null, 'message' => "Data Anda dengan NIM $id berhasil dibaharukan"
            ];
            return $this->respond($response);
        }

    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelSalon = new ModelSalon();
        $cekData = $modelSalon->find($id);
        if ($cekData) {
            $modelSalon->delete($id);
            $response = ['status' => 200, 'error' => null, 'message' => "Selamat data sudah berhasil dihapus maksimal"];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
