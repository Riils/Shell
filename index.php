<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembelian Bahan Bakar</title>
    <style>
        body {
            text-align: center;
            margin: 0;
            padding: 0;
            background-color:  grey;
            background-size: cover;
            font-family: Arial, sans-serif;
            background-attachment:fixed;
        }   

        #container {
            width: 70%;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 120px;
            text-align: left;
            color: #666;
            font-weight: bold;
        }

        select,
        input[type="number"],
        button {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            width: 200px;
        }

        button {
            background-color: #FFC100;
            color: #fff;
            cursor: pointer;
            width: 95px;
        }

        button:hover {
            background-color:  orange;
        }

        .bukti-transaksi {
            background-color:  wheat;
            border-radius: 5px;
            padding: 15px;
            border: 2px dashed #999;
            margin-top: 20px;
        }

        hr {
            border: none;
            height: 3px;
            background-color: #ccc;
            margin: 20px auto;
        }

        @media screen and (max-width: 600px) {
            label {
                width: 100%;
                text-align: center;
            }

            select,
            input[type="number"] {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Form Transaksi Bahan Bakar</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter:</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <label for="payment">Metode Pembayaran:</label>
            <select id="payment" name="payment">
                <option value="Tunai">Tunai</option>
                <option value="Non Tunai">Non Tunai</option>
            </select>
            <br><br>
            <button type="submit">Beli</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;
                protected $payment;

                public function __construct($jenis, $harga, $jumlah, $payment)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN tetap 10%
                    $this->payment = $payment;
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }

                public function getPayment()
                {
                    return $this->payment;
                }
            }

            class Beli extends Shell
            {
                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTransaksi()
                {
                    $total = $this->hitungTotal();
                    echo "<div class='bukti-transaksi'>";
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda membeli bahan bakar dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>";
                    echo "<p><strong>Dibayar via : </strong>" . $this->payment . "</p>";
                    echo "<p><strong>Total yang harus anda bayar : </strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "</div>";
                }
            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];
            $payment = $_POST["payment"];

            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah, $payment);
                $beli->buktiTransaksi();
            } else {
                echo "<p>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>
    </div>
</body>

</html>
