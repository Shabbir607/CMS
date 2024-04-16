<template>
    <div class="header">
        <div class="headerinfo">
            <div class="headertype">
                <h3>Purchase Order Details</h3>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="print">
                <span>#: {{ otherDetails.po_no }}</span>
                <span style="cursor: pointer;" @click="downloadPDF"><i class="fa-solid fa-print mx-2"
                        style="font-size: 20px;"></i>Print</span>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <div id="PrintDiv">
                        <div class="invoice-box table-height"
                            style="max-width: 1600px;width:100%;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                            <table class="table" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width:50%;padding:5px;vertical-align:top;text-align:left;">

                                            <font style="vertical-align: inherit;">
                                                <font
                                                    style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;">
                                                    {{ userName }}</font>
                                            </font><!--!--><br>
                                            <font style="vertical-align: inherit;">
                                                <font
                                                    style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                    {{ userEmail }}</font>
                                            </font><!--!--><br>

                                            <br>
                                        </td><!--!-->

                                        <td style="width:50%;padding:5px;vertical-align:top;text-align:right;">
                                            <font style="vertical-align: inherit;margin-bottom:25px;">
                                                <font
                                                    style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px;font-size:28pt; ">
                                                    Purchase Order</font>
                                            </font><!--!--><br>
                                            <font style="vertical-align: inherit;">
                                                <font
                                                    style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                    # {{ otherDetails.po_no }}</font>
                                            </font><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%;padding:5px;vertical-align:top;text-align:left;">
                                            <font
                                                style="vertical-align: inherit;font-size:14px;color:#9D568A;font-weight:600;line-height: 35px; ">
                                                To</font><br>
                                            <font v-if="otherDetails.supplier"
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 600;">
                                                {{ otherDetails.supplier.name }} </font><!--!--><br>

                                            <font v-if="otherDetails.supplier"
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                {{ otherDetails.supplier.email }}</font><!--!--><br>

                                        </td>
                                        <td style="width:50%;padding:5px;vertical-align:top;text-align:right;"><!--!--><br>
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                PO Date: {{ otherDetails.order_date }}</font><!--!--><br>
                                            <font
                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                Expected Date: {{ otherDetails.expected_date }}</font><br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="invoice-box">
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 70%;">Product Name</th>
                                            <th style="width: 15%;">QTY</th>
                                            <th style="width: 15%;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in stockDetails" :key="item.id" style="border-top: 1px solid rgb(219, 217, 217);">
                                            <td>{{ item.product.name }}</td>
                                            <td>{{ item.quantity }}</td>
                                            <td>{{ item.amount }}</td>
                                        </tr>
                                        <tr style="border-top: 1px solid rgb(219, 217, 217);">
                                            <td></td>
                                            <td style="font-weight: bold;">Total</td>
                                            <td style="font-weight: bold;">{{ otherDetails.total_value }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br><br><br><br><br><br>
                            </div>

                        </div>
                        <table class="w-100">
                            <tr class="w-50">
                                <td style="padding-top:10px;">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 700;">
                                            Terms and Conditions </font>
                                    </font><br>
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;font-size: 15px;color:#000;font-weight: 400;">
                                            {{ otherDetails.terms_and_conditions }}</font>
                                    </font><br>
                                </td>
                            </tr>
                        </table>

                        <div style="margin-top:10px;" class="row">
                            <div class="w-80"></div>
                        </div>
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
    name: 'StockTransferDetail',
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
            const response = await axios.get(`api/purchase_order/detail/${this.$route.params.id}`);
            this.stockDetails = response.data.product;
            this.otherDetails = response.data.data;

            console.log(response)

            const formattedDate = format(new Date(this.otherDetails.order_date), 'dd-MMM-yyyy');
            this.otherDetails.order_date = formattedDate;
            const formattedDate2 = format(new Date(this.otherDetails.expected_date), 'dd-MMM-yyyy');
            this.otherDetails.expected_date = formattedDate2;
        } catch (error) {
                console.error('Error Occur While Fetching Data', error);
            }
        },

        async downloadPDF() {
            const pdfElement = document.getElementById('PrintDiv');

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
            doc.save('data.pdf');
        },
    },
    mounted() {
        this.dataFetch()

        const storedUser = localStorage.getItem('user');

        if (storedUser) {
            // Parse the stored user information
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
}
</style>