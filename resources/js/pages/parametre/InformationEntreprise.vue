<template>
    <div class="card mt-3 me-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white pt-3 pb-3">
            <h5 class="text-muted">Information de l'entreprise</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 mb-3">
                    <Input v-if="!loading" v-model="form.nom" :error="errors.nom" required>Nom de l'entreprise</Input>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                </div>
                <div class="col-xl-6 mb-3">
                    <Input v-if="!loading" v-model="form.contact" :error="errors.contact" required>Contact</Input>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                </div>
                <div class="col-xl-6 mb-3">
                    <Input v-if="!loading" v-model="form.email" :error="errors.email" type="email" required>Adresse email</Input>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                </div>
                <div class="col-xl-6 mb-3">
                    <label v-if="!loading" for="tva" class="form-label">TVA</label>
                    <select v-if="!loading" id="tva" v-model="form.assujeti" class="form-control">
                        <option :value="true">Assujeti a la TVA</option>
                        <option :value="false">Non assujeti a la TVA</option>
                    </select>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                    <span v-if="errors.assujeti">{{ errors.assujeti[0] }}</span>
                </div>
                <div class="col-xl-6 mb-3">
                    <Input v-if="!loading" v-model="form.nif" :error="errors.nif">NIF</Input>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                </div>
                <div class="col-xl-6 mb-3">
                    <Input v-if="!loading" v-model="form.stat" :error="errors.stat">STAT</Input>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="100%" height="40" />
                </div>
                <div class="col-xl-12 d-flex justify-content-end mt-3">
                    <SaveBtn v-if="!loading" :loading="creating || updating" @click="save">Enregistrer</SaveBtn>
                    <Skeletor v-else style="border-radius: 3px; margin-bottom: 5px;" width="10%" height="40" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onBeforeMount, ref } from '@vue/runtime-core'
import Input from '../../components/html/Input.vue'
import SaveBtn from '../../components/html/SaveBtn.vue'
import useCRUD from '../../services/CRUDServices'
import { Skeletor } from 'vue-skeletor'

const { entity, create, errors, creating, loading, updating, find, update } = useCRUD("/parametres/generale");

export default {
    components: {
        Input,
        SaveBtn,
        Skeletor,
    },
    setup() {
        const form = ref({
            nom: null,
            contact: null,
            email: null,
            assujeti: true,
            nif: null,
            stat: null,
        });

        const save = async () => {
            if (entity.value === "") await create(form.value);
            else await update(entity.value.id, form.value);
        }

        onBeforeMount(async () => {
            await find(null)

            if (entity.value !== "") {
                form.value = {
                    nom: entity.value.generale.nom,
                    contact: entity.value.generale.contact,
                    email: entity.value.generale.email,
                    assujeti: entity.value.generale.assujeti,
                    nif: entity.value.generale.nif,
                    stat: entity.value.generale.stat,
                }
            }
        })

        return {
            form, errors, creating, create, save, entity, find, loading, updating, update,
        }
    }
}

</script>
