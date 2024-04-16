
<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Supplier Payment</h3>
                <h5>View Supplier Payment Details</h5>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="print">
                <span>Supplier Payment Detail: {{ otherDetails.spay_no }}</span>
                <span style="cursor: pointer;" @click="downloadPDF"><i class="fa-solid fa-print mx-2"
                        style="font-size: 20px;"></i>Print</span>
            </div>
            <hr>

            <div id="PDFinvoice"><!--!-->
                <div style="text-align:center;">
                    <font
                        style="text-align:center;vertical-align: inherit;font-size:16px;color:white;background-color:#9D568A;padding:10px;padding-inline: 60px;font-weight:bold;line-height: 35px; ">
                        Payment</font><br>
                </div>
                <div class="invoice-box table-height"
                    style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                    <table style="width: 100%;line-height: inherit;text-align: left;">
                        <tbody>
                            <tr>
                                <td style="width:36%;padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                    <!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Paid To</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font v-if="otherDetails.supplier"
                                            style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ otherDetails.supplier.name }}</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font v-if="otherDetails.supplier"
                                            style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ otherDetails.supplier.email }}</font>
                                    </font><!--!--><br>
                                </td><!--!-->
                                <td style="width:34%;padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                    <!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Company Info</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ userName }}</font>
                                    </font><!--!--><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            {{ userEmail }}</font>
                                    </font><br>
                                </td>
                                <td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px"><!--!-->
                                    <font style="vertical-align: inherit;margin-bottom:25px;">
                                        <font
                                            style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                            Details</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            No: {{ otherDetails.spay_no }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Date: {{ otherDetails.date }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                            Mode: {{ otherDetails.pay_mode }}</font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 800;">
                                            Amount: {{ otherDetails.amount }}</font>
                                    </font><br>
                                </td>
                            </tr>
                        </tbody>
                    </table><!--!-->
                    <table class="table" cellpadding="0" cellspacing="0"
                        style="width: 100%;line-height: inherit;text-align: left;">
                        <thead>
                            <tr class="heading " style="background: #F3F2F7;">
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Purchase No
                                </td><!--!-->
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Invoice No
                                </td>
                                <!--!-->
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000;font-size: 14px;padding: 10px; ">
                                    Invoice Date
                                </td>
                                <td
                                    style="padding: 5px;vertical-align: middle;font-weight: 600;color: #fafafa; background: #000000; font-size: 14px;padding: 10px; ">
                                    Amount
                                </td>
                            </tr>
                        </thead><!--!-->
                        <tbody>
                            <tr v-for="item in stockDetails" :key="item.id" class="details"
                                style="border-bottom:1px solid #E9ECEF ;">
                                <td style="padding: 10px;vertical-align: top; ">{{ item.invoice.bill_no }}</td>
                                <td style="padding: 10px;vertical-align: top; ">{{ item.invoice.invoice_no }}</td>
                                <td style="padding: 10px;vertical-align: top; ">{{ item.invoice.invoice_date }}</td>
                                <td style="padding: 10px;vertical-align: top; ">{{ item.paying }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="font-weight: 800;">Total</td>
                                <td style="font-weight: 800;">{{ otherDetails.amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table>

                    <tr>
                        <td>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 700;">
                                    Narration </font>
                            </font><br>
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 400;">
                                    {{ otherDetails.narration }}</font>
                            </font><br>
                        </td>
                    </tr>
                </table>
                <div class="row" style="margin-top:10px">
                    <div class="col-lg-10"><!--!-->
                        <h7>Created by:</h7> <br>
                        <h7 style="font-size:12px;">{{ userName }}</h7> <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import { format } from 'date-fns';

export default {
    name: 'SupplierPaymentDetail',
    data() {
        return {
            stockDetails: '',
            otherDetails: {},
            userName: '',
            userEmail: '',
        }
    },
    methods: {
        async dataFetch() {
            try{
            const response = await axios.get(`api/supplier_payment/detail/${this.$route.params.id}`);
            this.stockDetails = response.data.invoices;
            this.otherDetails = response.data.data;

            console.log(response)

            const formattedDate = format(new Date(this.otherDetails.date), 'dd-MMM-yyyy');
            this.otherDetails.date = formattedDate;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        async downloadPDF() {
            const pdfElement = document.getElementById('PDFinvoice');

            // Use html2canvas to capture the content as an image
            const canvas = await html2canvas(pdfElement);

            // Configuration for jsPDF
            const pdfOptions = {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait',
            };

            // Create a new jsPDF instance
            const doc = new jsPDF(pdfOptions);

            // Configure the imageSmoothingEnabled property for the PDF
            doc.context2d.imageSmoothingEnabled = false;

            // Calculate the width and height of the image on the PDF
            const imgWidth = 190;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add the captured image to the PDF
            doc.addImage(canvas, 'PNG', 10, 10, imgWidth, imgHeight);

            // Save the PDF with a specified filename
            doc.save('supplier-payment.pdf');
        },
    },
    mounted() {
        this.dataFetch()

        const storedUser = localStorage.getItem('user');

        if (storedUser) {
            const user = JSON.parse(storedUser);
            this.userName = user.name;
            this.userEmail = user.email;
        }


    }
}
</script>

<style scoped>
.print {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

td,
th {
    border: none;
}</style>