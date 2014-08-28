<?php
if (realpath(__FILE__) == realpath($_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'])){
    Header("Location: ../../index.php");
}
/* 
 * Copyright (C) 2014 darkfr3ak <info at darkfr3ak.de>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

$userFiles = $this->loadBasket($_SESSION['user_id']);
?>
        <div class="page-header">
            <h2>Geplante Downloads</h2>
        </div>
        <div class="row">
                <div class="col-sm-12 col-md-10 col-md-offset-1">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Hinzugefügt</th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($userFiles as $userFile) {
                                $userFileData = $this->getFile($userFile->cart_fileID);
                            ?>
                            <tr>
                                <td class="col-sm-8 col-md-6">
                                    <div class="media">
                                        <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?php echo $this->getCurrentApp(); ?>images/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="index.php?app=download&task=file&id=<?php echo $userFileData->file_id; ?>"><?php echo $userFileData->file_dispName; ?></a></h4>
                                            <h5 class="media-heading"> Version <a href="#"><?php echo $userFileData->file_version; ?></a></h5>
                                            <span>Status: </span><span class="text-success"><strong>Not downloaded</strong></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1" style="text-align: center">
                                    <?php echo $this->formatDate($userFile->cart_date, true); ?>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center"><strong></strong></td>
                                <td class="col-sm-1 col-md-1 text-center"><strong></strong></td>
                                <td class="col-sm-1 col-md-1">
                                    <a href="index.php?app=download&task=remove&id=<?php echo $userFile->cart_fileID; ?>" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span> Remove
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <a href="index.php?app=download" class="btn btn-default">
                                        <span class="glyphicon glyphicon-shopping-cart"></span> Continue Downloading
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success">
                                        Download All <span class="glyphicon glyphicon-play"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

<?php
//header("location: ../" . DOWNLOAD_FOLDER_NAME ."/". $filename);
?>