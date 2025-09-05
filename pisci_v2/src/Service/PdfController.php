<?php
// src/Service/PdfGenerator.php

namespace App\Service;

use FPDF;

class PdfGenerator extends FPDF
{
    protected $widths;
    protected $aligns;
    protected $isFooter;

    function SetFooter($w)
    {
        $this->isFooter = $w;
    }

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, $a, false);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    // Método para generar el ticket de venta
    public function generateTicket($venta)
    {
        $this->AddPage();
        $this->SetFont('Arial', '', 12);
        
        // Simular la lógica de tu ticket
        $this->Cell(40, 5, utf8_decode('Piscina Municipal'), 0, 1, 'L');
        $this->Cell(40, 5, utf8_decode('Ticket de Venta'), 0, 1, 'L');
        $this->Ln(5);

        foreach ($venta->getVentaDetalles() as $detalle) {
            $this->Cell(40, 5, utf8_decode($detalle->getProducto()->getNombre()), 0, 1, 'L');
            $this->Cell(40, 5, utf8_decode('Cantidad: ') . $detalle->getCtd(), 0, 1, 'L');
            $this->Cell(40, 5, utf8_decode('Precio: ') . $detalle->getPrecio(), 0, 1, 'L');
            $this->Ln(5);
        }
        
        $this->Output('D', 'ticket_' . $venta->getId() . '.pdf');
    }
}